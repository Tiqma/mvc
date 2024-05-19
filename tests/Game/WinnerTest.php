<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Winner.
 */
class WinnerTest extends TestCase
{
    /**
     * Testar att determine returnerar 'Banker' när spelaren har bustat.
     *
     * @return void
     */
    public function testDeterminePlayerBusted(): void
    {
        $player = new Player();
        $banker = new Bank();

        $player->hit('♠K');
        $player->hit('♥Q');

        $this->assertEquals('Banker', Winner::determine($player, $banker));
    }

    /**
     * Testar att determine returnerar 'Player' när bankiren har bustat.
     *
     * @return void
     */
    public function testDetermineBankerBusted(): void
    {
        $player = new Player();
        $banker = new Bank();

        $banker->hit('♠K');
        $banker->hit('♥Q');

        $this->assertEquals('Player', Winner::determine($player, $banker));
    }

    /**
     * Testar att determine returnerar 'Player' när spelaren har fler poäng än bankiren.
     *
     * @return void
     */
    public function testDeterminePlayerWins(): void
    {
        $player = new Player();
        $banker = new Bank();

        $player->hit('♠9');
        $player->hit('♥8');

        $banker->hit('♠7');
        $banker->hit('♥7');

        $this->assertEquals('Player', Winner::determine($player, $banker));
    }

    /**
     * Testar att determine returnerar 'Banker' när bankiren har fler poäng än spelaren.
     *
     * @return void
     */
    public function testDetermineBankerWins(): void
    {
        $player = new Player();
        $banker = new Bank();

        $player->hit('♠7');
        $player->hit('♥7');

        $banker->hit('♠9');
        $banker->hit('♥8');

        $this->assertEquals('Banker', Winner::determine($player, $banker));
    }

    /**
     * Testar att determine returnerar 'Banker' när spelaren och bankiren har lika många poäng.
     *
     * @return void
     */
    public function testDetermineTieGoesToBanker(): void
    {
        $player = new Player();
        $banker = new Bank();

        $player->hit('♠8');
        $player->hit('♥9');

        $banker->hit('♠10');
        $banker->hit('♦7');

        $this->assertEquals('Banker', Winner::determine($player, $banker));
    }
}
