<?php
//src/AppBundle/Service/Card.php
namespace AppBundle\Service;

class Card
{
    protected $number   = '';
    protected $color    = '';
    protected $score    = 0;

    public function name(): string
    {
        return $this->number . ' ' . $this->color;
    }



    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber($number): bool
    {
        $this->number = $number;
        return true;
    }



    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor($color): bool
    {
        $this->color = $color;
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
}