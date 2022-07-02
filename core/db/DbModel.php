<?php

namespace app\core\db;

use app\core\App;
use app\core\form\InputField;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    public function get($where = [])
    {
        return $this->where($where)->fetchAll(\PDO::FETCH_CLASS);
    }

    public function paginate($pageNumber, $limit, $where = [])
    {
        return $this->where($where, $limit, ($pageNumber * $limit) - $limit)->fetchAll(\PDO::FETCH_CLASS);
    }

    public function findOne($where)
    {
        return $this->where($where)->fetch(\PDO::FETCH_OBJ);
    }

    public function where($where, $limit = null, $offset = null, $select = "*")
    {
        $tableName = $this->tableName();

        $attributes = array_keys($where);

        $sqlWhere = implode(' AND ', array_map(fn($attr) => "$attr " . $where[$attr][0] . " :$attr" , $attributes));
        if (!empty($where))
            $sqlWhere = "WHERE " . $sqlWhere;

        $sqlLimitOffset = "";
        if ($limit !== null)
            $sqlLimitOffset = "LIMIT $limit ";
        if ($offset !== null)
            $sqlLimitOffset .= "OFFSET $offset";
        $statement = App::db()->prepare("SELECT $select FROM $tableName $sqlWhere $sqlLimitOffset;");

        foreach ($where as $key => $value)
            $statement->bindValue(":$key", ($value[2] ?? "") . $value[1] . ($value[3] ?? ""));

        $statement->execute();

        return $statement;
    }

    // Count all records
    public function count($where = []): int
    {
        $rows = $this->where($where, null, null, "count(*)")->fetchColumn();

        return intval($rows);
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
}