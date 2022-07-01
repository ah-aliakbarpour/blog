<?php

namespace app\core\form;

use app\core\Model;

class From
{

    public static function begin(string $action, string $method, string $property = ''): From
    {
        echo sprintf('<form action="%s" method="%s" %s>', $action, $method, $property);
        return new From();
    }

    public static function end(): void
    {
        echo '</form>';
    }

    public function input(Model $model, string $attribute, string $type): InputField
    {
        return new InputField($model, $attribute, $type);
    }

    public function textArea(Model $model,string $attribute): TextareaField
    {
        return new TextareaField($model, $attribute);
    }
}