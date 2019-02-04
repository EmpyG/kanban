<?php

namespace App;

use App\Entities\Board;

class TaskLoader
{
    private $dbConn;

    public function __construct(LoaderInterface $cfg)
    {
        $this->dbConn = DatabaseConnect::getDatabase($cfg);
    }

    /**
     * Counts amount of tasks in the database
     *
     * @return void
     */
    public function getAmount()
    {
        $count = $this->dbConn->count(
            Board::TABLE_NAME,
            Board::ID
        );
        echo $count;
    }

    /**
     * Displays tasks in relevant place based on their's status
     *
     * @param int $status
     * @return void
     */
    public function listDisplay(int $status)
    {
        $array = $this->dbConn->select(
            Board::TABLE_NAME,
            [Board::ID, Board::DESC, Board::DEADLINE],
            [Board::STATUS => $status, Board::ACTIVE => 1]
        );

        echo '<ul>';
        foreach ($array as $int => $task) {
            $val = $int + 1;
            echo sprintf(
                '<li> %s . %s . %s. %s </li>',
                $val,
                $task[Board::ID],
                $task[Board::DESC],
                $task[Board::DEADLINE]
            );
        }
        echo '</ul>';
    }

    /**
     * Selects all data form database
     *
     * @return void
     */
    private function getList(): void
    {
        $array = $this->dbConn->select(
            "board",
            ["id", "status", "description", "deadline"]
        );
    }
}