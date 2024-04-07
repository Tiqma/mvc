<?php

namespace App\Card;

class CardHand extends DeckOfCards
{
    private $deck;

    private $hand = [];

    public function __construct(array $cards)
    {
        $this->hand = $cards;
    }

    public function getHand()
    {
        return $this->hand;
    }

    public function clearHand()
    {
        $this->hand = [];
    }

    public function addCards(array $cards)
    {
        $this->hand = array_merge($this->hand, $cards);
    }
}
