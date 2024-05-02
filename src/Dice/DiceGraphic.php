<?php

namespace App\Dice;

class DiceGraphic extends Dice
{
    /**
     * Grafiska representationer av tärningssidor.
     *
     * @var string[]
     */
    private array $representation = [
        '⚀',
        '⚁',
        '⚂',
        '⚃',
        '⚄',
        '⚅',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }
}
