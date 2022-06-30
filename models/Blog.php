<?php

namespace app\models;

use app\core\App;
use app\core\db\DbModel;
use app\core\Model;

class Blog extends DbModel
{
    public string $title = '';
    public string $author = '';
    public string $context = '';

    public function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED],
            'author' => [self::RULE_REQUIRED],
            'context' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'title' => 'Title',
            'author' => 'Author',
            'context' => 'Context',
        ];
    }

    public function tableName(): string
    {
        return 'blogs';
    }

    public function attributes(): array
    {
        return ['title', 'author', 'context'];
    }
}