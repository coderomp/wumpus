<?php

class Position {

    public $x;
    public $y;

    public function __construct($x, $y)
    {
        if (!isset($x)) {
            throw new Exception('X coordinate must be provided for cartesian position.');
        }

        if (!isset($y)) {
            throw new Exception('Y coordinate must be provided for cartesian position.');
        }

        $this->x = $x;
        $this->y = $y;
    }

    public static function isObjectOverlapping($object1, $object2)
    {
        if ($object1->position->x == $object2->position->x && $object1->position->y == $object2->position->y) {
            return true;
        } else {
            return false;
        }
    }
}