<?php

namespace App\Card;

class Card
{
    protected $suit;
    protected $rank;

    public function __construct($suit, $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    public function getSuit()
    {
        return $this->suit;
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function getCard()
    {
        return $this->suit . $this->rank;
    }
}
