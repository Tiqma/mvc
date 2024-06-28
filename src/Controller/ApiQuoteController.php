<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Game\Player;
use App\Game\Bank;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;

class ApiQuoteController extends AbstractController
{
    #[Route("/api/quote", name: "api_quote")]
    public function getQuote(): JsonResponse
    {
        $quotes = [
            "Förändring är lagen för livet. Och de som ser bara på det förflutna 
            eller nuet är säkert att missa framtiden.",
            "Den som kontrollerar kryddan, kontrollerar universum.",
            "Styrkan hos en person ligger inte i deras fysiska förmåga, 
            utan i deras förmåga att kontrollera sina tankar.",
        ];

        $randomQuote = $quotes[array_rand($quotes)];


        $data = [
            'quote' => $randomQuote,
            'date' => date('Y-m-d'),
            'timestamp' => time(),
        ];

        return new JsonResponse($data);
    }
}
