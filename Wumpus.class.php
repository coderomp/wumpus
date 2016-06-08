<?php

class Wumpus extends Character {

    public function __construct($x, $y)
    {
        $this->position = new Position($x, $y);
        $this->representation = '[W]';
    }

    public function __toString()
    {
        return $this->representation;
    }
}