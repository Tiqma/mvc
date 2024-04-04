<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    #[Route("/api")]
    public function jsonNumber(): Response
    {
        $landing = "/api";
        $quote = "/api/quote";

        $data = [
            'all-apis' => 'These are the api routes!',
            'landing' => $landing,
            'quote' => $quote,

        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/quote")]
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
