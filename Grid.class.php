<?php

class Grid {

    protected $size;
    protected $layout;

    public function __construct($size = 10)
    {
        $this->size = $size;
        $this->layout = [[]];

        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                $this->layout[$i][$j] = new Tile($i, $j);
            }
        }
    }

    public function displayGrid($hunter, $wumpus, $smells = null, $arrow = null)
    {
        if (!$hunter instanceof Hunter) {
            throw new Exception("Hunter object required for displaying game.");
        }

        if (!$wumpus instanceof Wumpus) {
            throw new Exception("Wumpus object required for displaying game.");
        }

        if (empty($smells)) {
            throw new Exception("Smells were not defined for the Wumpus.");
        }

        $size = $this->size;

        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                if ($arrow instanceof Arrow && $arrow->position->x == $j && $arrow->position->y == $i) {
                    echo $arrow;
                } elseif ($hunter->position->x == $j && $hunter->position->y == $i) {
                    echo $hunter;
                } elseif ($wumpus->position->x == $j && $wumpus->position->y == $i) {
                    echo $wumpus;
                } elseif ($smells[0]->position->x == $j && $smells[0]->position->y == $i) {
                    echo $smells[0];
                } elseif ($smells[1]->position->x == $j && $smells[1]->position->y == $i) {
                    echo $smells[1];
                } elseif ($smells[2]->position->x == $j && $smells[2]->position->y == $i) {
                    echo $smells[2];
                } elseif ($smells[3]->position->x == $j && $smells[3]->position->y == $i) {
                    echo $smells[3];
                } else {
                    echo $this->layout[$j][$i];
                }
            }

            echo "\n";
        }
    }

}