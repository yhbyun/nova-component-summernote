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

    public $preview = '';

    /**
     * 상세화면에 value 대신 표신할 html
     *
     * @param [string] $html
     * @return $this
     */
    public function preview(string $html)
    {
        $this->preview = $html;

        return $this;
    }

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
            'preview' => $this->preview,
            'shouldShow' => $this->shouldBeExpanded(),
        ]);
    }
}
