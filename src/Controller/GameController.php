<?php
// src/Controller/GameController.php
namespace App\Controller;

use AppBundle\Service\Card;
use AppBundle\Service\Game;
use AppBundle\Service\Player;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController
{
    /**
      * @Route("/game/start")
      */
    public function start(): Response
    {
        //get card package and shuffle it
        $Game = new Game();

        $Game->shuffle();

        $cards = $Game->getCards();

        //create players and distrivute the cards
        $Player1 = new Player();
        $Player2 = new Player();
        $Player3 = new Player();
        $Player4 = new Player();

        $Player1->setName('Martin Fleisher');
        $Player3->setName('Joe Grue');
        $Player1->setTeam('USA');
        $Player3->setTeam('USA');

        $Player2->setName('Yan Huang');
        $Player4->setName('Nan Wang');
        $Player2->setTeam('CHINA');
        $Player4->setTeam('CHINA');

        $i = 1;
        foreach ($cards as $Card)
        {
            if(5 == $i)
            {
                $i = 1;
            }

            $playerId = "Player$i";
            $$playerId->addCard($Card);

            $i++;
        }

        //playing now
        $echo       = "Game Starting!<br />";
        $loopWinner = 1;
        $color      = '';

        for ($i = 1; $i <= 13; ++$i)
        {
            //ini loop
            $echo .= "Loop $i:<br />";

            $id     = $loopWinner;
            $color  = '';
            $Best   = null;
            $tables = [];

            //parse player
            for ($j = 1; $j <= 4; ++$j)
            {
                $playerId = "Player$id";

                $Card = $$playerId->play($color);

                array_push($tables, $Card);

                $echo .= $$playerId->getName() . " play " . $Card->name() . "<br />";

                //get trump card
                if('' == $color)
                {
                    $color      = $Card->getColor();
                    $Best       = $Card;
                    $loopWinner = $id;
                }

                //add score bonus for trump card
                $scoreBest = $Best->getScore();
                $scoreCard = $Card->getScore();

                if($Best->getColor() == $color)
                {
                    $scoreBest += 100;
                }

                if($Card->getColor() == $color)
                {
                    $scoreCard += 100;
                }

                //keep new best card
                if($scoreCard > $scoreBest)
                {
                    $loopWinner = $id;
                }

                //calculate id
                $id++;

                if(5 == $id)
                {
                    $id = 1;
                }
            }

            //show the winner
            $playerId = "Player$loopWinner";

            $echo .= '-> Winner is ' . $$playerId->getName() . '<br />';

            //add score to winner
            $score = $$playerId->getScore();

            foreach ($tables as $Card)
            {
                $score += $Card->getScore();
            }

            $$playerId->setScore($score);

            $echo .= '<br />';
        }

        //calculate team score
        $scoreTeam1 = $Player1->getScore() + $Player3->getScore();
        $scoreTeam2 = $Player2->getScore() + $Player4->getScore();

        $team = $Player1->getTeam();

        if($scoreTeam2 > $scoreTeam1)
        {
            $team = $Player2->getTeam();
        }

        $echo .= "===> $team WIN!!!<br />";

        //print result
        return new Response(
            "<html><body>$echo</body></html>"
        );
    }
}