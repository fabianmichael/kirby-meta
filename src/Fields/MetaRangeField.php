<?php

namespace FabianMichael\Meta\Fields;

use Kirby\Form\Field\RangeField;

class MetaRangeField extends RangeField
{
    use HasOverride;

    public function toFormValue(): float|null
    {
        if ($this->hasOverride() === true) {
            return static::toNumber($this->override());
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
