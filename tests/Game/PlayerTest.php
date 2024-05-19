<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{
    /**
     * Testar att clearHand rensar spelarens hand.
     */
    public function testClearHand(): void
    {
        $player = new Player();
        $player->hit('♠6');
        $player->hit('♥10');

        $this->assertNotEmpty($player->getHand());
        $player->clearHand();
        $this->assertEmpty($player->getHand());
    }

    /**
     * Testar att hasBusted returnerar true när spelarens poäng överstiger 21.
     */
    public function testHasBusted(): void
    {
        $player = new Player();
        $player->hit('♠K');
        $player->hit('♥Q');

        $this->assertTrue($player->hasBusted()); // Spelaren har bustat (överstiger 21)
    }

    /**
     * Testar att hasBusted returnerar false när spelarens poäng är 21 eller mindre.
     */
    public function testHasNotBusted(): void
    {
        $player = new Player();
        $player->hit('♠7');
        $player->hit('♥8');
        $player->hit('♦6');

        $this->assertFalse($player->hasBusted()); // Spelaren har inte bustat (21 eller mindre)
    }
}
