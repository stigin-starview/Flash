<?php

declare(strict_types=1);
/**
 * Handles the database query's for the messagebox table
 * This logic can be avoided in this class as it is standard
 * Be a intermediary layer on top of models in the future !
 */
// TODO: Add current logic into Databasemodel class

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
        return static::save();
    }

    public function getAllMessages(): array
    {
        return static::all();
    }
}