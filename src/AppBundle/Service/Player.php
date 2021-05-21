<?php
//src/AppBundle/Service/Player.php
namespace AppBundle\Service;

use AppBundle\Service\Card;

class Player
{
    protected $name     = '';
    protected $team     = '';
    protected $score    = 0;
    protected $cards    = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): bool
    {
        $this->name = $name;
        return true;
    }



    public function getTeam(): string
    {
        return $this->team;
    }

    public function setTeam($team): bool
    {
        $this->team = $team;
        return true;
    }



    public function getScore(): string
    {
        return $this->score;
    }

    public function setScore($score): bool
    {
        $this->score = $score;
        return true;
    }


    public function addCard(Card $Card): bool
    {
        array_push($this->cards, $Card);
        return true;
    }

    public function play(string $color = '')
    {
        $Best   = null;
        $remove = null;

        foreach ($this->cards as $key => $Card)
        {
            //take first card
            if(null === $Best)
            {
                $Best   = $Card;
                $remove = $key;
                continue;
            }

            $scoreBest = $Best->getScore();
            $scoreCard = $Card->getScore();

            //add score bonus for trump card
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
                $Best   = $Card;
                $remove = $key;
            }
        }

        //take off card
        unset($this->cards[$remove]);

        return $Best;
    }
}