<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Game\Player;
use App\Game\Bank;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route("/game/doc", name:"gamedoc")]
    public function gamedoc(
        SessionInterface $session
    ): Response {
        return $this->render("game/doc.html.twig");
    }

    #[Route("/game", name:"introgame")]
    public function intro(
        SessionInterface $session
    ): Response {
        return $this->render("game/intro.html.twig");
    }

    #[Route("/game/start", name:"start", methods: ['POST'])]
    public function start(
        SessionInterface $session
    ): Response {
        $deckOfCards = new DeckOfCards();
        $deckOfCards->shuffleDeck();
        $shuffledDeck = $deckOfCards->getDeck();

        $session->set("deck", $shuffledDeck);
        return $this->render("game/start.html.twig");
    }

    #[Route("/game/draw", name: "draw_21")]
    public function drawgame(SessionInterface $session): Response {
        /** @var Player|null $player */
        $player = $session->get('player', null);
        if ($player === null) {
            $player = new Player();
        }
        /** @var string[] $deckOfCards */
        $deckOfCards = $session->get('deck');
        $deckOfCards = DeckOfCards::createFromSession($deckOfCards);

        $drawnCard = $deckOfCards->drawCard();

        $player->hit($drawnCard);
        $session->set('deck', $deckOfCards->getDeck());
        $session->set('player', $player);

        return $this->render('game/draw.html.twig', [
            'drawnCard' => $drawnCard,
            'remainingCardsCount' => $deckOfCards->countCards(),
            'hand' => $player->getHand(),
            'totalpoints' => $player->getTotalPoints(),
            'hasBusted' => $player->hasBusted(),
        ]);
    }

    #[Route("/game/bank", name:"bank", methods: ['POST'])]
    public function bank(
        SessionInterface $session
    ): Response {
        /** @var Player $player */
        $player = $session->get('player');
        /** @var string[] $deckOfCards */
        $deckOfCards = $session->get('deck');
        $deckOfCards = DeckOfCards::createFromSession($deckOfCards);

        $banker = new Bank();
        $banker->playBankerTurn($deckOfCards);

        $playerHasBusted = $player->hasBusted();
        $bankerHasBusted = $banker->hasBusted();

        $winner = null;
        if ($playerHasBusted) {
            $winner = 'Banker';
        } elseif ($bankerHasBusted) {
            $winner = 'Player';
        } else {
            if ($player->getTotalPoints() > $banker->getTotalPoints()) {
                $winner = 'Player';
            } else {
                $winner = 'Banker';
            }
        }

        return $this->render("game/bank.html.twig", [
            'playerHand' => $player->getHand(),
            'playerPoints' => $player->getTotalPoints(),
            'bankerHand' => $banker->getHand(),
            'bankerPoints' => $banker->getTotalPoints(),
            'winner' => $winner,
            'playerHasBusted' => $playerHasBusted,
            'bankerHasBusted' => $bankerHasBusted,
        ]);
    }
}

