<?php

namespace FabianMichael\Meta\Fields;

use Kirby\Form\Field\TogglesField;

class MetaRobotsIndexTogglesField extends TogglesField
{
    use HasOverride;

    public function options(): array
    {
        $model = $this->model();

        return array_map(function ($option) use ($model) {
            if ($option['value'] !== '') {
                return $option;
            }

            $option['text'] = tt('fabianmichael.meta.robots_index.auto', [
                'state' => $model->isIndexable()
                    ? t('fabianmichael.meta.state.on')
                    : t('fabianmichael.meta.state.off'),
            ]);
            $option['icon'] = "status-{$model->status()}";

            return $option;
        }, parent::options());
    }

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
