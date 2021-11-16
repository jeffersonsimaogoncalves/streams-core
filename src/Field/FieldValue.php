<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\ForwardsCalls;

class FieldValue
{
    use Macroable;
    use ForwardsCalls;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}