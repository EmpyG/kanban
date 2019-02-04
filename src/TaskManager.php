<?php declare (strict_types=1);

namespace App;

use App\Entities\Board;
use App\Exceptions\TaskAlreadyExistsException;
use App\Exceptions\TaskSetInFutureException;
use DateTime;
use Exception;

class TaskManager
{
    /**
     * Status codes
     */
    public const STATUS_TODO = 1;
    public const STATUS_WORK = 2;
    public const STATUS_FINISHED = 3;

    /**
     * Exception messages
     */
    private const TASK_EXISTS_MESSAGE = 'This task already exists.';
    private const TASK_IN_PAST_MESSAGE = 'Task can\'t be set in past.';

    /**
     * @var \Medoo\Medoo
     */
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
     * Adds new task to the database, doesn't add task if there is task with the same desc already exists
     *
     * @param int    $status
     * @param string $description desc of the task
     * @param string $deadline    line that is dead
     * @return bool
     * @throws TaskAlreadyExistsException
     * @throws TaskSetInFutureException
     * @throws Exception
     */
    public function addToBoard(int $status, string $description, $deadline): bool
    {
        if ($this->taskExist($description)) {
            throw new TaskAlreadyExistsException(self::TASK_EXISTS_MESSAGE);
        }

        if ($this->isTaskSetInPast($deadline)) {
            throw new TaskSetInFutureException(self::TASK_IN_PAST_MESSAGE);
        }

        //inserts new task to the database
        $this->dbConn->insert(
            Board::TABLE_NAME, [
            Board::ID       => null,
            Board::STATUS   => $status,
            Board::DESC     => $description,
            Board::DEADLINE => $deadline
        ]);
        return true;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->dbConn->select(
            Board::TABLE_NAME,
            [
                Board::ID,
                Board::STATUS,
                Board::DESC,
                Board::DEADLINE
            ]);
    }

    /**
     * Sets task status to "Work in progress"
     *
     * @param int $id
     * @param int $status
     * @return void
     * add $status next to int id
     */
    public function updateTaskStatus(int $id, int $status): void
    {
        $this->dbConn->update(
            Board::TABLE_NAME,
            [Board::STATUS => $status],
            [Board::ID => $id]
        );
    }

    /**
     * Deletes task
     *
     * @param int $id
     */
    public function deleteTask(int $id): void
    {
        $this->dbConn->delete(
            Board::TABLE_NAME, [
            "AND" => [
                Board::ID     => $id,
                Board::STATUS => self::STATUS_FINISHED
            ]
        ]);
    }
}