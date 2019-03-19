<?php

namespace Cimpleo\NovaSummernote;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Expandable;

class NovaSummernote extends Field
{
    use Expandable;

    public $showOnIndex = false;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-summernote';

    public $preview = '';

    public function __construct(string $name, ?string $attribute = null, ?mixed $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta(
            [
                'options' => [
                    'use_lfm' => false,
                ],
            ]
        );
    }

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
        $currentOptions = $this->meta['options'];

        return $this->withMeta(['options' => array_merge($currentOptions, $options)]);
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
