<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response {
        $sessionData = $session->all();

        return $this->render('session/session.html.twig', [
            'sessionData' => $sessionData,
        ]);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function deleteSession(
        SessionInterface $session
    ): Response {
        $session->clear();

        $this->addFlash(
            'warning',
            'Session Deleted!'
        );

        return $this->redirectToRoute('session');
    }

    #[Route("/card", name:"card")]
    public function card(
        SessionInterface $session
    ): Response {
        return $this->render("card/card.html.twig");
    }

    #[Route("/card/deck", name: "deck_of_cards")]
    public function deck(DeckOfCards $deckOfCards): Response
    {
        $cards = $deckOfCards->getDeck();

        return $this->render('card/deck.html.twig', [
            'cards' => $cards,
        ]);
    }

    #[Route("/card/init", name: "card_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('card/init.html.twig');
    }

    #[Route("/card/init", name: "card_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();

        $deck->shuffleDeck();

        $session->set("deck", $deck);

        return $this->redirectToRoute('card_deck_shuffle');
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffle(
        SessionInterface $session
    ): Response {
        $deckOfCards = new DeckOfCards();
        $deckOfCards->shuffleDeck();
        $shuffledDeck = $deckOfCards->getDeck();

        $session->set("deck", $shuffledDeck);

        return $this->render('card/deck_shuffle.html.twig', [
            'shuffledDeck' => $shuffledDeck,
        ]);
    }

    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function draw(
        SessionInterface $session
    ): Response {
        $deckOfCards = $session->get('deck');
        $deckOfCards = DeckOfCards::createFromSession($deckOfCards);

        $drawnCard = $deckOfCards->drawCard();
        $remainingCardsCount = $deckOfCards->countCards();

        $session->set('deck', $deckOfCards->getDeck());

        return $this->render('card/deck_draw.html.twig', [
            'drawnCard' => $drawnCard,
            'remainingCardsCount' => $remainingCardsCount,
        ]);
    }

    #[Route("/card/deck/draw/{numCards<\d+>}", name: "card_deck_draw_more")]
    public function drawMoreCards(
        SessionInterface $session,
        int $numCards
    ): Response {
        $deckOfCards = $session->get('deck');
        $deckOfCards = DeckOfCards::createFromSession($deckOfCards);

        $drawnCards = $deckOfCards->drawCards($numCards);
        $drawnCards = $drawnCards->getHand();

        $remainingCardsCount = $deckOfCards->countCards();

        $session->set('deck', $deckOfCards->getDeck());

        return $this->render('card/deck_draw_more.html.twig', [
            'drawnCards' => $drawnCards,
            'numCards' => $numCards,
            'remainingCardsCount' => $remainingCardsCount,
        ]);
    }

}
