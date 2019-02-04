<?php declare (strict_types=1);

namespace App;

use App\Entities\Board;
use DateTime;

class TaskManager
{
    private const NOT_STARTED = 1;
    private const WORK_IN_PROGRESS = 2;
    private const FINISHED = 3;

    private $dbConn;

    /**
     * @var DateTime time now
     */
    private $date;

    /**
     * TaskManager constructor.
     *
     * @param LoaderInterface $cfg
     * @throws \Exception
     */
    public function __construct(LoaderInterface $cfg)
    {
        $this->dbConn = DatabaseConnect::getDatabase($cfg);
        $this->date = new DateTime('now');
    }

    /**
     * Adds new task to the database, doesn't add task if there is task with the same desc already exists
     *
     * @param int    $status
     * @param string $description desc of the task
     * @param string $deadline    line that is dead
     * @return bool
     * @throws \Exception
     */
    public function addToBoard(int $status, string $description, $deadline): bool
    {
        if ($this->taskExist($description)) {
            return false;
        }

        if ($this->isTaskSetInPast($deadline)) {
            return false;
        }

        //inserts new task to the database
        $newTask = $this->dbConn->insert(
            Board::TABLE_NAME, [
            Board::ID       => null,
            Board::STATUS   => $status,
            Board::DESC     => $description,
            Board::DEADLINE => $deadline,
            Board::ACTIVE   => 1,
        ]);
        return true;
    }

    /**
     * Checks if the same task is already in the database
     *
     * @param string $description desc of the task
     *
     * @return bool
     */
    private function taskExist(string $description): bool
    {
        return $this->dbConn->has(
            Board::TABLE_NAME,
            [Board::DESC => $description]
        );
    }

    /**
     * @param $deadline
     * @return bool true if task is set in past, false otherwise
     * @throws \Exception
     */
    public function isTaskSetInPast(string $deadline): bool
    {
        $deadlineDate = new DateTime($deadline);

        // true if deadline is in past
        return ($deadlineDate->getTimestamp() <= $this->date->getTimestamp());
    }

    /**
     * Sets task status to "Work in progress"
     *
     * @param int $id
     * @return void
     * add $status next to int id
     */
    public function updateTaskStatus(int $id): void
    {
        $updateTask = $this->dbConn->update(
            Board::TABLE_NAME,
            [Board::STATUS . '[+]' => 1],
            [Board::ID => $id]
        );
    }

    /**
     * Sets task status to "Work in progress"
     *
     * @param int $id
     * @return void
     * add $status next to int id
     */
    public function updateTaskWork(int $id): void
    {
        $updateTask = $this->dbConn->update(
            Board::TABLE_NAME,
            [Board::STATUS => self::WORK_IN_PROGRESS],
            [Board::ID => $id]
        );
    }

    /**
     * Sets task status to "Finished"
     *
     * @param int $id
     * @return void
     */
    public function updateTaskFinish(int $id): void
    {
        $finishTask = $this->dbConn->update(
            Board::TABLE_NAME,
            [Board::STATUS => self::FINISHED],
            [Board::ID => $id]
        );
    }

    /**
     * Sets task's active property
     *
     * @param int $id
     * @return void
     */
    public function setActiveStatus(int $id, int $active): void
    {
        $setActive = $this->dbConn->update(
            Board::TABLE_NAME,
            [Board::ACTIVE => $active],
            [Board::ID => $id]
        );
    }
}