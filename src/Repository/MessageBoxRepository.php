<?php

declare(strict_types=1);
/**
 * Handles the database query's for the messagebox table
 */
// TODO: Add current logic into dDatabasemodel class
namespace learnspace\flash\Repository;

use learnspace\flash\System\DatabaseModel;

class MessageBoxRepository extends DatabaseModel
{
    protected static $table = 'messages_box';

    public function __construct()
    {
        parent::__construct();
        // Make sure the connection is set here
        if (static::$connection === null) {
            throw new \Exception("Database connection not set.");
        }
    }

    public function saveMessage($content)
    {
        $this->attributes['content'] = $content;
        return $this->save();
    }

    public function getAllMessages(): array
    {
        return static::all();
    }
}