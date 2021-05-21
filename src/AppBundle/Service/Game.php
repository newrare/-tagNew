<?php
//src/AppBundle/Service/Game.php
namespace AppBundle\Service;

use AppBundle\Service\Card;

class Game
{
    protected $colors   = ['spade', 'club', 'heart', 'diamond'];
    protected $numbers  = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'jack', 'queen', 'king', 'ace'];
    protected $cards    = [];

    public function __construct()
    {
        foreach ($this->colors as $color)
        {
            $score = 1;

            foreach ($this->numbers as $number)
            {
                $Card = new Card();

                $Card->setNumber($number);
                $Card->setColor($color);
                $Card->setScore($score);

                $score++;

                array_push($this->cards, $Card);
            }
        }

        return true;
    }

    public function shuffle(): bool
    {
        return shuffle($this->cards);
    }

    public function getCards(): array
    {
        return $this->cards;
    }
}