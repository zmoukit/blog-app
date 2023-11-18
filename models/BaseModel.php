<?php

namespace Models;

use Core\Application;

abstract class BaseModel
{
    protected const RULE_REQUIRED = 'required';
    protected const RULE_EMAIL = 'email';
    protected const RULE_MOBILE = 'mobile';
    protected const RULE_MIN = 'min';
    protected const RULE_MAX = 'max';
    protected const RULE_MATCH = 'match';
    protected const RULE_NULLABLE = 'nullable';
    protected const RULE_DATE = 'date';
    protected const RULE_DATE_FORMAT = 'date_format';
    protected const RULE_UNIQUE = 'unique';

    protected array $errors = [];

    /**
     * Validation rules to apply on model
     * 
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Get Model attributes labels
     * 
     * @return array 
     */
    public function labels(): array
    {
        return [];
    }

    /**
     * Get model attribute label
     * 
     * @param string $attribute
     * 
     * @return string 
     */
    public function getLabel($attribute): string
    {
        return $this->labels()[$attribute] ?? ucfirst(str_replace("_", " ", $attribute));
    }

    /**
     * Load model data
     * 
     * @param array $data
     * 
     * @return void
     */
    public function loadData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function validate()
    {
        foreach ($this->rules() as $attributeName => $rules) {
            $value = $this->{$attributeName};

            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                // validate required fields
                if (self::RULE_REQUIRED === $ruleName && trim($value) === "") {
                    $this->addErrorForRule($attributeName, self::RULE_REQUIRED);
                }

                // validate email
                if (self::RULE_EMAIL === $ruleName && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attributeName, self::RULE_EMAIL);
                }

                // Min validation
                if (self::RULE_MIN === $ruleName && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attributeName, self::RULE_MIN, $rule);
                }

                // Max validation
                if (self::RULE_MAX === $ruleName && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attributeName, self::RULE_MAX, $rule);
                }

                // match validation
                if (self::RULE_MATCH === $ruleName && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attributeName, self::RULE_MATCH, $rule);
                }

                // unique validation
                if (self::RULE_UNIQUE === $ruleName) {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attributeName;
                    $tableName = $className::tableName();

                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttribute = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();

                    if ($record) {
                        $this->addErrorForRule($attributeName, self::RULE_UNIQUE, ['field' => $this->getLabel($attributeName)]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    private function addErrorForRule($attribute, $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? "Error";
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $message = str_replace("{{$key}}", $value, $message);
            }
        }
        $this->errors[$attribute][] = $message;
    }

    /**
     * Add error message
     */
    public function addError($attribute, $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'The field is required.',
            self::RULE_EMAIL => 'The field must be a valid email address.',
            self::RULE_MOBILE => 'mobile',
            self::RULE_MIN => 'The field must be at least {min} characters',
            self::RULE_MAX => 'The field may not be greater than {max} characters.',
            self::RULE_MATCH => 'The field confirmation does not match the {match} field.',
            self::RULE_DATE => 'The field is not a valid date',
            self::RULE_DATE_FORMAT => 'The field does not match the format {format}.',
            self::RULE_UNIQUE => 'The {field} has already been taken.'
        ];
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
