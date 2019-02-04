<?php declare(strict_types=1);

namespace App\Entities;

/**
 * Holds fields name as constant
 *
 * @package App\Entities
 */
abstract class Board
{
    /**
     * Table name
     */
    public const TABLE_NAME = 'board';

    /**
     * Fields name
     */
    public const ID = 'id';
    public const STATUS = 'status';
    public const DESC = 'description';
    public const DEADLINE = 'deadline';
    public const ACTIVE = 'active';

}