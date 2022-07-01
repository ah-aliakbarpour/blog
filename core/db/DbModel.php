<?php

namespace app\core\db;

use app\core\App;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    public function get()
    {
        $tableName = $this->tableName();

        $data = App::db()->query("SELECT * FROM $tableName");

        return $data->fetchAll(\PDO::FETCH_CLASS);
    }

    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($attribute) => ":$attribute", $attributes);

        $statement = App::db()->prepare(
            "INSERT INTO $tableName(" . implode(', ', $attributes) . ")
            VALUES(" . implode(', ', $params) . ")"
        );

        foreach ($attributes as $attribute)
            $statement->bindValue(":$attribute", $this->{$attribute});

        $statement->execute();

        return true;
    }

    public function update($id): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($attribute) => "$attribute = :$attribute", $attributes);

        $statement = App::db()->prepare(
            "UPDATE $tableName
            SET " . implode(', ', $params) .
            " WHERE id = $id;"
        );

        foreach ($attributes as $attribute)
            $statement->bindValue(":$attribute", $this->{$attribute});

        $statement->execute();

        return true;
    }

    public function destroy($id): bool
    {
        $tableName = $this->tableName();

        $statement = App::db()->prepare(
            "DELETE FROM $tableName WHERE id = $id;"
        );

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

        return $statement->fetch(\PDO::FETCH_OBJ);
    }
}