<?php

namespace App\Dice;

use App\Dice\Dice;

class DiceHand
{
    /** @var Dice[] */
    private array $hand = [];

    public function add(Dice $die): void
    {
        $this->hand[] = $die;
    }

    public function roll(): void
    {
        foreach ($this->hand as $die) {
            $die->roll();
        }
    }

    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    /**
     * Returnerar värdena för varje tärning i handen.
     *
     * @return int[]
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getValue();
        }
        return $values;
    }

    /**
     * Returnerar strängrepresentationerna för varje tärning i handen.
     *
     * @return string[]
     */
    public function getString(): array
    {
        $strings = [];
        foreach ($this->hand as $die) {
            $strings[] = $die->getAsString();
        }
        return $strings;
    }
}
