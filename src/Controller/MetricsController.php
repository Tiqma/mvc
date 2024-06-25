<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MetricsController
{
    #[Route('/metrics', name: "metrics")]
    public function number(): Response
    {
        return $this->render("metrics/report.html.twig");
    }
}
