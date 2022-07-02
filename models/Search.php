<?php

namespace app\models;

use app\core\Model;

class Search extends Model
{
    public string $search = '';

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