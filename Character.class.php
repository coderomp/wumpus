<?php

class Character {

    public $position;
    public $representation;

    public function __construct($x, $y)
    {
        $this->position = new Position($x, $y);
    }

}