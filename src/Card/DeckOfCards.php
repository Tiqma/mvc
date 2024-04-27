<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    private $suits = ['♠', '♥', '♦', '♣'];
    private $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    private $deck = [];

    public function __construct()
    {
        $this->initializeDeck();
    }

    private function initializeDeck()
    {
        foreach ($this->suits as $suit) {
            foreach ($this->ranks as $rank) {
                $this->deck[] = $suit . $rank;
                //$this->deck[] = new CardGraphic($suit, $rank);
            }
        }
    }

    public function getDeck()
    {
        return $this->deck;
    }

    public function drawCard()
    {
        if (count($this->deck) > 0) {
            return array_pop($this->deck);
        } else {
            return null;
        }
    }

    public function drawCards($numCards)
    {
        $drawnCards = [];
        for ($i = 0; $i < $numCards; $i++) {
            $drawnCard = $this->drawCard();
            if ($drawnCard !== null) {
                $drawnCards[] = $drawnCard;
            } else {
                break;
            }
        }
        return new CardHand($drawnCards);
    }

    public function shuffleDeck()
    {
        shuffle($this->deck);
    }

    public function countCards()
    {
        return count($this->deck);
    }

    public function isEmpty()
    {
        return empty($this->deck);
    }

    public static function createFromSession($cardsArray)
    {
        $deck = new self();
        $deck->deck = $cardsArray;
        return $deck;
    }
}
