<?php

namespace App\Game;

use App\Card\DeckOfCards;

class Bank extends Player
{
    /**
     * Avgör om bankiren ska stanna.
     *
     * @return bool
     */
    public function shouldStop(): bool
    {
        $totalPoints = $this->getTotalPoints();
        return $totalPoints >= 17;
    }

    /**
     * Spelar bankirens tur genom att dra kort från given kortlek tills shouldStop() är sant.
     *
     * @param DeckOfCards $deck
     * @return string[]
     */
    public function playBankerTurn(DeckOfCards $deck): array
    {
        while (!$this->shouldStop()) {
            $this->hit($deck->drawCard());
        }

        return $this->getHand();
    }
}
