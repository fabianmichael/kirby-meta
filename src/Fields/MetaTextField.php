<?php

namespace FabianMichael\Meta\Fields;

use Kirby\Form\Field\TextField;

class MetaTextField extends TextField
{
    use HasOverride;

    public function toFormValue(): string
    {
        if ($this->hasOverride() === true) {
            return (string)$this->override();
        }

        return parent::toFormValue();
    }

    public function toStoredValue(): mixed
    {
        // get old value from model if disabled
        return $this->isDisabled()
            ? $this->model()->content()->get($this->name())->value()
            : parent::toStoredValue();
    }
}
