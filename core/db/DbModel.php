<?php

namespace app\core\db;

use app\core\App;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    //abstract public function primaryKey(): string;


    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statement = App::db()->prepare("
            INSERT INTO $tableName(" . implode(', ', $attributes) . ")
            VALUES(" . implode(', ', $params) . ")
                            ");

        foreach ($attributes as $attribute)
            $statement->bindValue(":$attribute", $this->{$attribute});

        $statement->execute();

        return true;
    }

    public function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);

        $sqlWhere = implode('AND ', array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = App::db()->prepare("SELECT * FROM $tableName WHERE $sqlWhere");
        foreach ($where as $key => $value)
            $statement->bindValue(":$key", $value);

        $statement->execute();

        return $statement->fetchObject(static::class);
    }
}