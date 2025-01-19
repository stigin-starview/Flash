<?php

declare(strict_types=1);
/**
 * This class will make database communication in ORM style (objects)
 */
namespace learnspace\flash\System;

use PDO;

class DatabaseModel
{
    protected static $table;
    protected $attributes = [];
    protected static $connection;

    public function __construct($data = [])
    {
        $this->attributes = $data;
    }

    public static function setConnection(DatabaseConnection $connection)
    {
        static::$connection = $connection->getPDO();
    }

    public static function find($id)
    {
        $stmt = static::$connection->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new static($data) : null;
    }

    public static function all(): array
    {
        $stmt = static::$connection->query("SELECT * FROM " . static::$table);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative arrays

        $objects = [];
        foreach ($results as $row) {
            //Manually add the attributes - Populating directly did not work (protect)
            $object = new static();
            $object->attributes = $row;
            $objects[] = $object;
        }

        return $objects;
    }

    public function save()
    {
        $columns = implode(", ", array_keys($this->attributes));
        $placeholders = implode(", ", array_fill(0, count($this->attributes), "?"));
        $values = array_values($this->attributes);

        $stmt = static::$connection->prepare("INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)");
        return $stmt->execute($values);
    }

    public function delete()
    {
        if (!isset($this->attributes['id'])) {
            throw new \Exception("Cannot delete without an ID");
        }

        $stmt = static::$connection->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        return $stmt->execute([$this->attributes['id']]);
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }
}