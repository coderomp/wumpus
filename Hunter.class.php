<?php

class Hunter extends Character {

    public function __construct($x, $y)
    {
        $this->position = new Position($x, $y);
        $this->representation = '[H]';
    }

    public function __toString()
    {
        return $this->representation;
    }
}