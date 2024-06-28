<?php

namespace App\Game;

class Player
{
    /** @var string[] */
    private array $hand = [];

    /**
     * Lägger till ett kort till spelarens hand.
     *
     * @param string $card
     */
    public function hit(string $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * Returnerar spelarens hand.
     *
     * @return string[]
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * Beräknar totalpoängen för spelarens hand.
     *
     * @return int
     */
    public function getTotalPoints(): int
    {
        $totalPoints = 0;

        foreach ($this->hand as $card) {
            $rank = substr($card, 3);

            switch ($rank) {
                case 'A':
                    $totalPoints += 14;
                    if ($totalPoints > 21) {
                        $totalPoints -= 13;
                    }
                    break;
                case 'J':
                    $totalPoints += 11;
                    break;
                case 'Q':
                    $totalPoints += 12;
                    break;
                case 'K':
                    $totalPoints += 13;
                    break;
                default:
                    if (is_numeric($rank)) {
                        $totalPoints += (int)$rank;
                    }
                    break;
            }
        }

        return $totalPoints;
    }

    /**
     * Rensar spelarens hand.
     */
    public function clearHand(): void
    {
        $this->hand = [];
    }

    /**
     * Kollar om spelaren har bustat (överstigit 21 poäng).
     *
     * @return bool
     */
    public function hasBusted(): bool
    {
        return $this->getTotalPoints() > 21;
    }
}
