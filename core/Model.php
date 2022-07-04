<?php

namespace app\core;

abstract class Model
{
    // Error rules
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    // Error massages
    public const ERROR_MASSAGES = [
        self::RULE_REQUIRED => 'This field is required!',
        self::RULE_EMAIL => 'This field must be valid Email address!',
        self::RULE_MIN => 'Min length of this field must be bigger than {min}!',
        self::RULE_MAX => 'Max length of this field must be less than {max}!',
        self::RULE_MATCH => 'This field must be the same as {match}!',
        self::RULE_UNIQUE => 'Record with this {attribute} is already exists!'
    ];

    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key))
                $this->{$key} = $value;
        }
    }

    abstract public function rules(): array;

    public array $errors = [];

    public function validation()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName))
                    $ruleName = $rule[0];

                // Required
                if ($ruleName === self::RULE_REQUIRED && !$value)
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);

                // Email
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);

                // Min
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min'])
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);

                // Max
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max'])
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);

                // Match
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']})
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);

                // Unique
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $statement = App::$app->db->prepare("
                        SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr;
                    ");
                    $statement->bindValue(":$uniqueAttr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();

                    // If record fined with same attribute and value add error
                    if ($record)
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, $rule);
                }
            }
        }

        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        // get rule massage
        $massage = self::ERROR_MASSAGES[$rule] ?? '';

        // Bind label
        foreach ($params as $key => $value)
            $massage = str_replace('{' . $key . '}', $this->getLabel($value), $massage);

        // Add error
        $this->errors[$attribute][] = $massage;
    }

    // Check if an attribute has error
    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? '';
    }

    public function labels(): array
    {
        // If label method not implemented in model us database attributes as label
        return [];
    }

    public function getLabel($attribute): string
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

}