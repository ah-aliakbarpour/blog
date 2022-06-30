<?php

namespace app\models;

use app\core\App;
use app\core\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            $this->addError('email', 'User does not exist with this email!');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect!');
            return false;
        }

        var_dump($user);

        return App::$app->login($user);
    }

    public function labels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'password',
        ];
    }
}