<?php

namespace App\Game;

use App\Card\DeckOfCards;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Bank.
 */
class BankTest extends TestCase
{
    /**
     * Testar metoden shouldStop när totala poängen är mindre än 17.
     */
    public function testShouldStopBelow17(): void
    {
        $bank = new Bank();
        $bank->hit('♠6');
        $bank->hit('♥5');
        $this->assertFalse($bank->shouldStop());
    }

    /**
     * Testar metoden shouldStop när totala poängen är 17.
     */
    public function testShouldStopAt17(): void
    {
        $bank = new Bank();
        $bank->hit('♠A');
        $bank->hit('♥3');
        $this->assertTrue($bank->shouldStop());
    }

    /**
     * Testar metoden shouldStop när totala poängen är över 17.
     */
    public function testShouldStopAbove17(): void
    {
        $bank = new Bank();
        $bank->hit('♠A');
        $bank->hit('♥4');
        $this->assertTrue($bank->shouldStop());
    }

    /**
     * Testar att playBankerTurn drar kort tills shouldStop returnerar sant.
     */
    public function testPlayBankerTurn(): void
    {
        $deck = new DeckOfCards();
        $bank = new Bank();
        $deck->shuffleDeck();

        $bank->hit('♠6');
        $bank->hit('♥10');

        $bank->playBankerTurn($deck);

        $this->assertGreaterThanOrEqual(3, count($bank->getHand()));
        $this->assertGreaterThanOrEqual(17, $bank->getTotalPoints());
    }
}
