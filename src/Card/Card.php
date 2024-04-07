<?php

namespace App\Card;

class Card
{
    private $deck;

    public function __construct(DeckOfCards $deck)
    {
        $this->deck = $deck;
    }

    public function draw()
    {
        $card = $this->deck->drawCard();
        return $card;
    }
}
