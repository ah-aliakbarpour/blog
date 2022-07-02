<?php

namespace app\models;

use app\core\db\DbModel;

class User extends DbModel
{
    public string $name = '';


    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
        ];
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['name', 'access'];
    }


}