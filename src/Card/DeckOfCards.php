<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    /** @var string[] */
    private array $suits = ['♠', '♥', '♦', '♣']; // Anger att det är en array av strängar

    /** @var string[] */
    private array $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

    /** @var string[] */
    private array $deck = []; 

    public function __construct()
    {
        $this->initializeDeck();
    }

    /**
     * Initialiserar kortleken med kombinationer av suits och ranks.
     *
     * @return void
     */
    private function initializeDeck(): void
    {
        foreach ($this->suits as $suit) {
            foreach ($this->ranks as $rank) {
                $this->deck[] = $suit . $rank;
            }
        }
    }

    /**
     * Returnerar hela kortleken.
     *
     * @return string[] 
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    public function drawCard(): string
    {
        if (count($this->deck) > 0) {
            return array_pop($this->deck);
        } else {
            throw new \RuntimeException("Kortleken är tom. Kan inte dra fler kort.");
        }
    }

    /**
     * Drar flera kort från kortleken.
     *
     * @param int $numCards
     * @return CardHand
     */
    public function drawCards($numCards): CardHand
    {
        $drawnCards = [];
        for ($i = 0; $i < $numCards; $i++) {
            $drawnCard = $this->drawCard();
            if ($drawnCard !== null) {
                $drawnCards[] = $drawnCard;
            }
        }
        return new CardHand($drawnCards);
    }

    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }

    public function countCards(): int
    {
        return count($this->deck);
    }

    public function isEmpty(): bool
    {
        return empty($this->deck);
    }

    /**
     * Skapar en kortlek från en sessions-array.
     *
     * @param string[] $cardsArray
     * @return DeckOfCards
     */
    public static function createFromSession($cardsArray): DeckOfCards
    {
        $deck = new self();
        $deck->deck = $cardsArray;
        return $deck;
    }
}
