<?php

namespace App\Dice;

use RuntimeException;

class Dice
{
    protected ?int $value;

    public function __construct()
    {
        $this->value = null;
    }

    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    public function getValue(): int
    {
        if ($this->value === null) {
            throw new RuntimeException("Tärningen har inte rullats ännu.");
        }
        return $this->value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
