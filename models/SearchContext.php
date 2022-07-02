<?php

namespace app\models;

use app\core\Model;

class SearchContext extends Model
{
    public string $sc = '';

    public function rules(): array
    {
        return [
            'sc' => [],
        ];
    }

    public function labels(): array
    {
        return [
            'sc' => 'Search In Context',
        ];
    }
}