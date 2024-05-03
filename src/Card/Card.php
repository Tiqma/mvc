<?php

namespace App\Card;

class Card
{
    /** @var string */
    protected string $suit;

    /** @var string */
    protected string $rank;

    /**
     * @param string $suit
     * @param string $rank
     */
    public function __construct(string $suit, string $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    /**
     * Returnerar färgen på kortet.
     *
     * @return string
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Returnerar ranken på kortet.
     *
     * @return string
     */
    public function getRank(): string
    {
        return $this->rank;
    }

    /**
     * Returnerar färg och rank på kortet.
     *
     * @return string
     */
    public function getCard(): string
    {
        return $this->suit . $this->rank;
    }
}
