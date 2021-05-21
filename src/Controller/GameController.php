<?php
// src/Controller/GameController.php
namespace App\Controller;

use AppBundle\Service\Card;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController
{
    /**
      * @Route("/game/start")
      */
    public function start(): Response
    {
        $Card = new Card();

        return new Response(
            '<html><body>Game Staring... ' . $Card->show() . '</body></html>'
        );
    }
}