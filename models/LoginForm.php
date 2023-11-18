<?php

namespace Models;

use Core\Application;

class LoginForm extends BaseModel
{
    /**
     * @var string $email
     */
    public string $email = "";

    /**
     * @var string $password
     */
    public string $password = "";

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Your Email'
        ];
    }

    public function login()
    {
        $user = UserModel::findOne(['email' => $this->email]);

        if (!$user) {
            $this->addError('email', "There's no account with the email you provided.");
            return false;
        }

        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', "Password is incorrect.");
            return false;
        }

        Application::$app->getSession()->set('user', [
            'id' => $user->id,
            'name' => $user->getDisplayName()
        ]);

        return true;
    }
}
