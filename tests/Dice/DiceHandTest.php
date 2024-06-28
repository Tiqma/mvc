<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Test cases for class DiceHand.
 */
class DiceHandTest extends TestCase
{
    /**
     * Test adding dice to the hand.
     */
    public function testAddDice(): void
    {
        $hand = new DiceHand();
        $die1 = new Dice();
        $die2 = new Dice();
        
        $hand->add($die1);
        $hand->add($die2);
        
        $this->assertEquals(2, $hand->getNumberDices());
    }

    /**
     * Test rolling all dice in the hand.
     */
    public function testRollDice(): void
    {
        $hand = new DiceHand();
        $die1 = new Dice();
        $die2 = new Dice();
        
        $hand->add($die1);
        $hand->add($die2);
        
        $hand->roll();
        
        $values = $hand->getValues();
        
        $this->assertCount(2, $values);
        $this->assertGreaterThanOrEqual(1, $values[0]);
        $this->assertLessThanOrEqual(6, $values[0]);
        $this->assertGreaterThanOrEqual(1, $values[1]);
        $this->assertLessThanOrEqual(6, $values[1]);
    }

    /**
     * Test getting values from an empty hand.
     */
    public function testGetValuesEmptyHand(): void
    {
        $hand = new DiceHand();
        $values = $hand->getValues();
        
        $this->assertEmpty($values);
    }

    /**
     * Test getting string representations of dice in the hand.
     */
    public function testGetString(): void
    {
        $hand = new DiceHand();
        $die1 = new Dice();
        $die2 = new Dice();
        
        $hand->add($die1);
        $hand->add($die2);
        
        $hand->roll();
        
        $strings = $hand->getString();
        
        $this->assertCount(2, $strings);
        $this->assertStringStartsWith('[', $strings[0]);
        $this->assertStringEndsWith(']', $strings[0]);
        $this->assertMatchesRegularExpression('/\[\d\]/', $strings[0]);
        $this->assertStringStartsWith('[', $strings[1]);
        $this->assertStringEndsWith(']', $strings[1]);
        $this->assertMatchesRegularExpression('/\[\d\]/', $strings[1]);
    }
}
