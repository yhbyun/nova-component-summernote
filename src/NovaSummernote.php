<?php

namespace Cimpleo\NovaSummernote;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Expandable;

class NovaSummernote extends Field
{
    use Expandable;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-summernote';

    public function options(array $options = [])
    {
        return $this->withMeta(['options' => $options]);
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'shouldShow' => $this->shouldBeExpanded(),
        ]);
    }
}
