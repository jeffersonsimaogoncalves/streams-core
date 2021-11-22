<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\DecimalValue;

class Decimal extends FieldType
{

    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'rules' => [
                'numeric',
            ],
        ], $attributes));
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function cast($value)
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        $float = floatval($value);

        if ($float && intval($float) != $float) {
            $value = $float;
        } else {
            $value = intval($value);
        }
        
        return round($value, $this->field->config('precision') ?: 1);
    }

    public function expand($value)
    {
        return new DecimalValue($value);
    }
    
    public function generate()
    {
        return $this->cast($this->generator()->randomElement([
            $this->generator()->randomNumber(),
            $this->generator()->randomFloat(),
            round($this->generator()->randomFloat(), 1),
        ]));
    }
}
