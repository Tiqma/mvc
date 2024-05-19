<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Test cases for class DeckOfCards.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Testar att ett objekt av klassen DeckOfCards kan skapas och att kortleken initialiseras korrekt.
     */
    public function testCreateDeckOfCards(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        $this->assertCount(52, $deck->getDeck());
    }

    /**
     * Testar att getDeck() returnerar hela kortleken.
     */
    public function testGetDeck(): void
    {
        $deck = new DeckOfCards();
        $this->assertCount(52, $deck->getDeck());
    }

    /**
     * Testar att drawCard() returnerar ett kort och minskar antalet kort i kortleken.
     */
    public function testDrawCard(): void
    {
        $deck = new DeckOfCards();
        $initialCount = $deck->countCards();
        $card = $deck->drawCard();
        $this->assertNotEmpty($card);
        $this->assertCount($initialCount - 1, $deck->getDeck());
    }

    /**
     * Testar att drawCard() kastar ett undantag när kortleken är tom.
     */
    public function testDrawCardException(): void
    {
        $this->expectException(RuntimeException::class);
        $deck = new DeckOfCards();
        while (!$deck->isEmpty()) {
            $deck->drawCard();
        }
        $deck->drawCard(); // Detta ska kasta ett undantag
    }

    /**
     * Testar att drawCards() returnerar en instans av CardHand med rätt antal kort.
     */
    public function testDrawCards(): void
    {
        $deck = new DeckOfCards();
        $numCards = 5;
        $cardHand = $deck->drawCards($numCards);
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);
        $this->assertCount($numCards, $cardHand->getHand());
        $this->assertCount(52 - $numCards, $deck->getDeck());
    }

    /**
     * Testar att shuffleDeck() blandar kortleken.
     */
    public function testShuffleDeck(): void
    {
        $deck = new DeckOfCards();
        $originalDeck = $deck->getDeck();
        $deck->shuffleDeck();
        $shuffledDeck = $deck->getDeck();
        $this->assertNotEquals($originalDeck, $shuffledDeck);
        $this->assertCount(52, $shuffledDeck);
    }

    /**
     * Testar att countCards() returnerar korrekt antal kort i kortleken.
     */
    public function testCountCards(): void
    {
        $deck = new DeckOfCards();
        $this->assertEquals(52, $deck->countCards());
        $deck->drawCard();
        $this->assertEquals(51, $deck->countCards());
    }

}
