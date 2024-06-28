<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Test that a Dice object can be created.
     */
    public function testCreateDice(): void
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);
    }

    /**
     * Test rolling the dice and verifying the value is within the expected range.
     */
    public function testRollDice(): void
    {
        $die = new Dice();
        $value = $die->roll();

        $this->assertGreaterThanOrEqual(1, $value);
        $this->assertLessThanOrEqual(6, $value);
    }

    /**
     * Test getting the value of the dice after rolling.
     */
    public function testGetValueAfterRoll(): void
    {
        $die = new Dice();
        $die->roll();
        $value = $die->getValue();

        $this->assertGreaterThanOrEqual(1, $value);
        $this->assertLessThanOrEqual(6, $value);
    }

    /**
     * Test that getting the value before rolling throws an exception.
     */
    public function testGetValueBeforeRoll(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Tärningen har inte rullats ännu.");

        $die = new Dice();
        $die->getValue();
    }

    /**
     * Test the getAsString method to ensure it returns the correct string representation.
     */
    public function testGetAsString(): void
    {
        $die = new Dice();
        $die->roll();
        $res = $die->getAsString();

        $this->assertStringStartsWith('[', $res);
        $this->assertStringEndsWith(']', $res);
        $this->assertMatchesRegularExpression('/\[\d\]/', $res);
    }
}

