<?php

namespace Spike\core\form;

use Spike\core\Model;

class Form
{
    public static function begin($action, $method): self
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}