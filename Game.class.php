<?php
spl_autoload_register(function ($className) {
    include $className . '.class.php';
});

class Game {

    /**
     * @var Game The reference to *Singleton* instance of this class
     */
    private static $instance;

    private static $grid;
    private static $hunter;
    private static $wumpus;
    private static $smells;
    private static $arrow;

    const BOARD_SIZE = 10;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Game The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === Game::$instance) {
            Game::$instance = new static();
        }

        return Game::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        Game::initialize();
        Game::$grid = new Grid(Game::BOARD_SIZE);
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

    public static function start()
    {
        while (true) {
            echo exec("clear");
            Game::checkInteractions();
            Game::$grid->displayGrid(Game::$hunter, Game::$wumpus, Game::$smells, Game::$arrow);

            Game::reinitialize();
            Game::listCommands();

            do {
                $command = Game::promptUser();
                $isValidMove = Game::checkHunterMovement($command);
            } while (!$isValidMove);

            Game::processCommand($command);
        }
    }

    protected static function processCommand($command)
    {
        switch ($command) {
            case 'exit' : exit("End Game - Thanks for playing.\n"); break;
            case 'move left'     : Game::$hunter->position->x--; break;
            case 'move up'       : Game::$hunter->position->y--; break;
            case 'move down'     : Game::$hunter->position->y++; break;
            case 'move right'    : Game::$hunter->position->x++; break;

            case 'shoot left'     : Game::$arrow = new Arrow(Game::$hunter->position->x - 1, Game::$hunter->position->y); break;
            case 'shoot up'       : Game::$arrow = new Arrow(Game::$hunter->position->x, Game::$hunter->position->y - 1); break;
            case 'shoot down'     : Game::$arrow = new Arrow(Game::$hunter->position->x, Game::$hunter->position->y + 1); break;
            case 'shoot right'    : Game::$arrow = new Arrow(Game::$hunter->position->x + 1, Game::$hunter->position->y); break;
        }
    }

    protected static function promptUser()
    {
        echo "Command: ";
        $handle = fopen ("php://stdin","r");
        $command = strtolower(trim(fgets($handle)));
        return $command;
    }

    protected static function checkInteractions()
    {
        if (Position::isObjectOverlapping(Game::$hunter, Game::$wumpus)) {
            exit("\nGame Over. You just became Wumpus snack.\n");
        }

        if (!empty(Game::$arrow) && Position::isObjectOverlapping(Game::$arrow, Game::$wumpus)) {
            exit("\nVictory. Congratulations, you just killed the Wumpus. EZ PZ.\n");
        }

        // check interaction between smell and hunter.
        foreach (Game::$smells as $smell) {
            if (Position::isObjectOverlapping(Game::$hunter, $smell)) {
                echo "\nYou smell the musky odor of the Wumpus\n";
                return true;
            }
        }
    }

    protected static function checkHunterMovement($proposedCommand)
    {
        $newX = null;
        $newY = null;

        switch ($proposedCommand) {
            case 'move left'     : $newX = Game::$hunter->position->x - 1; break;
            case 'move up'       : $newY = Game::$hunter->position->y - 1; break;
            case 'move down'     : $newY = Game::$hunter->position->y + 1; break;
            case 'move right'    : $newX = Game::$hunter->position->x + 1; break;
        }

        if (!empty($newX) && ($newX < 0 || $newX >= Game::BOARD_SIZE)) {
            echo "\nYou can not move that way!\n\n";
            return false;
        }

        if (!empty($newY) && ($newY < 0 || $newY >= Game::BOARD_SIZE)) {
            echo "\nYou can not move that way!\n\n";
            return false;
        }

        return true;
    }


    protected static function listCommands()
    {
        echo "\n";
        echo "List of commands:\n\n";
        echo "    exit           - Exits the game\n";
        echo "    move left      - Move Left\n";
        echo "    move up        - Move Up\n";
        echo "    move down      - Move Down\n";
        echo "    move right     - Move Right\n";
        echo "    shoot left     - Shoot Left\n";
        echo "    shoot up       - Shoot Up\n";
        echo "    shoot down     - Shoot Down\n";
        echo "    shoot right    - Shoot Right\n";
        echo "\n";
    }

    protected static function initialize()
    {
        // Randomly generating positions for the Hunter and the Wumpus. Do while they're not overlapping in position.
        do {
            $randomX1 = rand(0, Game::BOARD_SIZE - 1);
            $randomY1 = rand(0, Game::BOARD_SIZE - 1);

            $randomX2 = rand(0, Game::BOARD_SIZE - 1);
            $randomY2 = rand(0, Game::BOARD_SIZE - 1);
        } while ($randomX1 == $randomX2 && $randomY1 == $randomY2);

        Game::$arrow = null; // no shots fired yet.
        Game::$hunter = new Hunter($randomX1, $randomY1);
        Game::$wumpus = new Wumpus($randomX2, $randomY2);
        Game::initializeSmells();
    }

    protected static function reinitialize()
    {
        Game::$arrow = null;
    }

    protected static function initializeSmells()
    {
        $topSmell = new Smell(Game::$wumpus->position->x, Game::$wumpus->position->y - 1);
        $rightSmell = new Smell(Game::$wumpus->position->x + 1, Game::$wumpus->position->y);
        $bottomSmell = new Smell(Game::$wumpus->position->x, Game::$wumpus->position->y + 1);
        $leftSmell = new Smell(Game::$wumpus->position->x - 1, Game::$wumpus->position->y);

        Game::$smells[] = $topSmell;
        Game::$smells[] = $rightSmell;
        Game::$smells[] = $bottomSmell;
        Game::$smells[] = $leftSmell;
    }
}

$game = Game::getInstance();
$game::start();