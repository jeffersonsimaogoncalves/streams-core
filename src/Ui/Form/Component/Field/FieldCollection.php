<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Collection;

/**
 * Class FieldCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldCollection extends Collection
{

    /**
     * Return base fields only.
     * No translations.
     *
     * @return FieldCollection
     */
    public function base()
    {
        $fields = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if ($item->getLocale() == config('app.fallback_locale')) {
                $fields[] = $item;
            }
        }

        return new static($fields);
    }

    /**
     * Return all translations for a field.
     *
     * @param $field
     * @return FieldCollection
     */
    public function translations($field)
    {
        $fields = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if ($item->getField() == $field) {
                $fields[] = $item;
            }
        }

        return new static($fields);
    }

    /**
     * Get a field.
     *
     * @param mixed $key
     * @param null  $default
     * @return FieldType
     */
    public function get($key, $default = null)
    {
        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if ($item->getInputName() == $key) {
                return $item;
            }
        }

        return $this->get($default);
    }

    /**
     * Return only translatable fields.
     *
     * @return FieldCollection
     */
    public function translatable()
    {
        $translatable = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if ($item->getLocale()) {
                $translatable[] = $item;
            }
        }

        return new static($translatable);
    }

    /**
     * Return only NON translatable fields.
     *
     * @return FieldCollection
     */
    public function notTranslatable()
    {
        $fields = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if (!$item->getLocale()) {
                $fields[] = $item;
            }
        }

        return new static($fields);
    }

    /**
     * Return enabled fields.
     *
     * @return FieldCollection
     */
    public function enabled()
    {
        $enabled = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if (!$item->isDisabled()) {
                $enabled[] = $item;
            }
        }

        return new static($enabled);
    }

    /**
     * Return disabled fields.
     *
     * @return FieldCollection
     */
    public function disabled()
    {
        $disabled = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if ($item->isDisabled()) {
                $disabled[] = $item;
            }
        }

        return new static($disabled);
    }

    /**
     * Skip a field.
     *
     * @param $fieldSlug
     */
    public function skip($fieldSlug)
    {
        $this->forget($fieldSlug);
    }

    /**
     * Return non-SelfHandling fields.
     *
     * @return FieldCollection
     */
    public function allowed()
    {
        $allowed = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if (!$item instanceof SelfHandling) {
                $allowed[] = $item;
            }
        }

        return new static($allowed);
    }

    /**
     * Return SelfHandling fields.
     *
     * @return FieldCollection
     */
    public function selfHandling()
    {
        $selfHandling = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if ($item instanceof SelfHandling) {
                $selfHandling[] = $item;
            }
        }

        return new static($selfHandling);
    }

    /**
     * Forget a key.
     *
     * @param mixed $key
     */
    public function forget($key)
    {
        /* @var FieldType $item */
        foreach ($this->items as $index => $item) {
            if ($item->getField() == $key) {

                unset($this->items[$index]);

                break;
            }
        }
    }
}
