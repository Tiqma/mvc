<?php

namespace App\Card;

class CardGraphic extends Card
{
    /** @var array<string, array<string, string>> */
    private array $graphics = [
        '♠' => [
            'A' => '🂡', 'K' => '🂮', 'Q' => '🂭', 'J' => '🂫',
            '10' => '🂪', '9' => '🂩', '8' => '🂨', '7' => '🂧',
            '6' => '🂦', '5' => '🂥', '4' => '🂤', '3' => '🂣',
            '2' => '🂢'
        ],
        '♥' => [
            'A' => '🂡', 'K' => '🂮', 'Q' => '🂭', 'J' => '🂫',
            '10' => '🂪', '9' => '🂩', '8' => '🂨', '7' => '🂧',
            '6' => '🂦', '5' => '🂥', '4' => '🂤', '3' => '🂣',
            '2' => '🂢'
        ],
        '♦' => [
            'A' => '🂡', 'K' => '🂮', 'Q' => '🂭', 'J' => '🂫',
            '10' => '🂪', '9' => '🂩', '8' => '🂨', '7' => '🂧',
            '6' => '🂦', '5' => '🂥', '4' => '🂤', '3' => '🂣',
            '2' => '🂢'
        ],
        '♣' => [
            'A' => '🂡', 'K' => '🂮', 'Q' => '🂭', 'J' => '🂫',
            '10' => '🂪', '9' => '🂩', '8' => '🂨', '7' => '🂧',
            '6' => '🂦', '5' => '🂥', '4' => '🂤', '3' => '🂣',
            '2' => '🂢'
        ]
    ];

    /**
     * Returnerar grafisk representation av ett kort.
     *
     * @return string|null
     */
    public function getGraphic(): ?string
    {
        return $this->graphics[$this->suit][$this->rank] ?? null;
    }
}
