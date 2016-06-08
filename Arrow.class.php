<?php

class Arrow {

    public $position;
    protected $representation;

    public function __construct($x, $y)
    {
        $this->position = new Position($x, $y);
        $this->representation = '[*]';
    }

    public function __toString()
    {
        return $this->representation;
    }
}