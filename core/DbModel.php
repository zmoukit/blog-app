<?php

namespace Core;

use Models\BaseModel;
use PDOException;

abstract class DbModel extends BaseModel
{
    /**
     * Get model table name
     * 
     * @return string
     */
    abstract public static function tableName(): string;

    /**
     * Get model attributes
     * 
     * @return array
     */
    abstract public function attributes(): array;

    /**
     * 
     */
    public function save()
    {
        try {
            $tableName = $this->tableName();
            $attributes = $this->attributes();


            $columns = implode(', ', $attributes);
            $values = ':' . implode(', :', $attributes);

            $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";

            $statement = self::prepare($sql);

            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }

            $statement->execute();

            return true;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * Get PDO statement
     * 
     * @param string $sql
     * 
     * @return 
     */
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    /**
     * Find model by query
     * 
     * @param array $where
     * 
     * @return object|false
     * 
     */
    public static function findOne($where)
    {
        $tableName = static::tableName();

        $attributes = array_keys($where);

        $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();

        return $statement->fetchObject(static::class);
    }
}
