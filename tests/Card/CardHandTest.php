<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Testar att clearHand() rensar alla kort från handen.
     */
    public function testClearHand(): void
    {
        $hand = new CardHand(['♠A', '♥K', '♦Q']);
        $this->assertCount(3, $hand->getHand());

        $hand->clearHand();
        $this->assertCount(0, $hand->getHand());
    }

    /**
     * Testar att addCards() lägger till kort till handen.
     */
    public function testAddCards(): void
    {
        $hand = new CardHand(['♠A', '♥K']);
        $this->assertCount(2, $hand->getHand());

        $hand->addCards(['♦Q', '♣J']);
        $this->assertCount(4, $hand->getHand());
        $this->assertEquals(['♠A', '♥K', '♦Q', '♣J'], $hand->getHand());
    }
}
