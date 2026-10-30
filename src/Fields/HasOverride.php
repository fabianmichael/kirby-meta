<?php

namespace FabianMichael\Meta\Fields;

use Kirby\Cms\Page;
use Kirby\Toolkit\HtmlString;

/**
 * Disables a field and shows a notice, if the page model
 * overrides its value
 */
trait HasOverride
{
    public function disabled(): bool
    {
        if ($this->hasOverride() === true) {
            return true;
        }

        return parent::disabled();
    }

    public function help(): HtmlString|null
    {
        if ($this->hasOverride() === true) {
            return new HtmlString($this->kirby()->kirbytext(
                '<span><svg class="k-icon" aria-hidden="true" data-type="lock" style="display: inline-block; --icon-size: 1em; vertical-align: -.1em;"><use xlink:href="' . $this->kirby()->panel()->assets()->icons() . '#icon-lock"/></svg> ' .
                t('fabianmichael.meta.override.help') . '</span>'
            ));
        }

        return parent::help();
    }

    protected function hasOverride(): bool
    {
        $model = $this->model();

        return $model instanceof Page && $model->meta()->hasOverride($this->name());
    }

    protected function override(): mixed
    {
        return $this->model()->meta()->override($this->name());
    }
}
