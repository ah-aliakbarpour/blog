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
        $result = $this->where($where);
        return $result->fetchAll(\PDO::FETCH_CLASS);
    }

    public function paginate($currentPage, $limit, $where = []): array
    {
        $blogs = $this->search($where, $limit, ($currentPage* $limit) - $limit)->fetchAll(\PDO::FETCH_CLASS);

        // Get number of all records
        $allRecords = $this->count([
            ['title', 'context', 'name'], $where[1],
        ]);

        // Validate current page number
        if (!is_numeric($currentPage) || $currentPage < 1)
            $currentPage = 1;
        $currentPage = intval($currentPage);

        $allPages = ceil($allRecords / $limit);

        // Start of index in each page
        $start = ($currentPage * $limit) - $limit + 1;
        // End of index in each page
        $end = $start + $limit - 1;
        if ($end > $allRecords)
            $end = $allRecords;

        // Return necessary variables for paginating in view
        return [
            'records' => $blogs,
            'allRecords' => $allRecords,
            'allPages' => $allPages,
            'limit' => $limit,
            'currentPage' => $currentPage,
            'start' => $start,
            'end' => $end,
        ];
    }

    // Retrieve only one record from database
    public function findOne($where)
    {
        $result = $this->where($where);
        return $result->fetch(\PDO::FETCH_OBJ);
    }

    // Filter data
    public function where($where, $limit = null, $offset = null, $select = "*")
    {
        $tableName = $this->tableName();

        $attributes = array_keys($where);

        // Create sql for where clause
        $sqlWhere = implode(' AND ', array_map(fn($attr) => "$attr " . $where[$attr][0] . " :$attr" , $attributes));
        if (!empty($where))
            $sqlWhere = "WHERE " . $sqlWhere;

        // Create limit and offset claus
        $sqlLimitOffset = "";
        if ($limit !== null)
            $sqlLimitOffset = "LIMIT $limit ";
        if ($offset !== null)
            $sqlLimitOffset .= "OFFSET $offset";

        // Query in database
        $statement = App::db()->prepare("SELECT $select FROM $tableName $sqlWhere $sqlLimitOffset;");

        foreach ($where as $key => $value)
            $statement->bindValue(":$key", ($value[2] ?? "") . $value[1] . ($value[3] ?? ""));

        $statement->execute();

        return $statement;
    }

    // Search in given fields
    public function search($where, $limit = null, $offset = null, $select = "blogs.*, users.name as author")
    {
        $tableName = $this->tableName();

        $attributes = $where[0];
        $value = $where[1];

        // Create sql for where clause
        $sqlWhere = implode(' OR ', array_map(fn($attr) => "$attr LIKE :value" , $attributes));
        if (!empty($where))
            $sqlWhere = "WHERE " . $sqlWhere;

        // Create limit and offset claus
        $sqlLimitOffset = "";
        if ($limit !== null)
            $sqlLimitOffset = "LIMIT $limit ";
        if ($offset !== null)
            $sqlLimitOffset .= "OFFSET $offset";

        // Query in database
        $statement = App::db()->prepare(
            "SELECT $select FROM $tableName
            INNER JOIN users ON users.id=blogs.user_id   
            $sqlWhere $sqlLimitOffset;");

        foreach ($attributes as $item)
            $statement->bindValue("value", "%$value%");

        $statement->execute();

        return $statement;
    }

    // Count records
    public function count($where = []): int
    {
        $rows = $this->search($where, null, null, "count(*)")->fetchColumn();

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