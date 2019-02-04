<?php

namespace App;

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
            "board",
            "id"
        );
        echo $count;
    }

    /**
     * Displays tasks in relevant place based on their's status
     *
     * @return void
     */
    public function listDisplay(int $status)
    {
        $array = $this->dbConn->select(
            "board",
            ["id", "description", "deadline"],
            ["status" => $status, "active" => 1]
        );

        echo '<ul>';
        foreach ($array as $int => $task) {
            $val = $int + 1;
            echo "\n <li>" . $val . ". " . $task["id"] . ". " . $task["description"] . ": " . $task["deadline"] . "</li>";
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