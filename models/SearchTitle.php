<?php

namespace app\models;

use app\core\Model;

class SearchTitle extends Model
{
    public string $st = '';

    public function rules(): array
    {
        return [
            'st' => [],
        ];
    }

    public function labels(): array
    {
        return [
            'st' => 'Search In Title',
        ];
    }
}