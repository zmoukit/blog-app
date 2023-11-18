<?php

namespace Core\Form;

use Models\BaseModel;

class Form
{

    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo "</form>";
    }

    public function field(BaseModel $model, $attribute)
    {
        return new Field($model, $attribute);
    }
}
