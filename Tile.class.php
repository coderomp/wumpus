<?php

class Tile {

    public function __construct($x, $y)
    {
        $this->position = new Position($x, $y);
        $this->representation = '[_]';
    }

    public function __toString()
    {
        return $this->representation;
    }
}