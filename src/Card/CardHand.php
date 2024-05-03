<?php

namespace App\Card;

class CardHand extends DeckOfCards
{
    /** @var string[] */
    private array $hand;

    /**
     * @param string[] $cards
     */
    public function __construct(array $cards)
    {
        $this->hand = $cards;
    }

    /**
     * Returnerar handen med kort.
     *
     * @return string[]
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * Rensar korten från handen.
     *
     * @return void
     */
    public function clearHand(): void
    {
        $this->hand = [];
    }

    /**
     * Lägger till kort till handen.
     *
     * @param string[] $cards
     * @return void
     */
    public function addCards(array $cards): void
    {
        $this->hand = array_merge($this->hand, $cards);
    }
}
