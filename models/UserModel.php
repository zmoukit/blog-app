<?php

namespace Models;

use Core\DbModel;

class UserModel extends DbModel
{
    public string $first_name = '';
    public string $last_name = '';
    public string $mobile = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $created_at = '';
    public ?string $last_login = null;

    public static function tableName(): string
    {
        return 'users';
    }

    public function save()
    {
        if (is_null($this->created_at) || trim($this->created_at) === "") {
            $this->created_at = date('Y-m-d H:i:s');
        }

        if (trim($this->last_login) === "") {
            $this->last_login = null;
        }

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'first_name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 200]],
            'last_name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 200]],
            'mobile' => [[
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 50]],
            'password_confirmation' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    /**
     * return model attribues
     * 
     * @return array
     */
    public function attributes(): array
    {
        return [
            'first_name',
            'last_name',
            'mobile',
            'email',
            'password',
            'created_at',
            'last_login',
        ];
    }

    /**
     * Get Model attributes labels
     * 
     * @return array 
     */
    public function labels(): array
    {
        return [
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'password' => '¨Password',
            'password_confirmation' => 'Password Confirmation',
            'created_at' => 'Creation Date',
            'last_login' => 'Last login Time'
        ];
    }

    /**
     * Get user display name
     * 
     * @return string
     */
    public function getDisplayName()
    {
        return ucfirst($this->first_name) . " " . ucfirst($this->last_name);
    }
}
