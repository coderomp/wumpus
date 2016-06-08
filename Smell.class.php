<?php

class Smell {

    public function __construct($x, $y)
    {
        $this->position = new Position($x, $y);
        $this->representation = '[S]';
    }

    public function __toString()
    {
        return $this->representation;
    }
}