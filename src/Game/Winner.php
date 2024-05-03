<?php

namespace App\Game;

use App\Game\Player;
use App\Game\Bank;

class Winner
{
    public static function determine(Player $player, Bank $banker): string
    {
        if ($player->hasBusted()) {
            return 'Banker';
        }

        if ($banker->hasBusted()) {
            return 'Player';
        }

        return ($player->getTotalPoints() > $banker->getTotalPoints()) ? 'Player' : 'Banker';
    }
}
