<?php
/**
 * This file is part of the Gadgets package
 * @license http://opensource.org/licenses/MIT
 */
declare(strict_types=1);
namespace DecodeLabs\Gadgets;

//use Df\Flex\Formatter;

use DecodeLabs\Gadgets\Constraint\Requirable;
use DecodeLabs\Gadgets\Constraint\RequirableTrait;

class Sanitizer implements Requirable
{
    use RequirableTrait;

    protected $value;

    /**
     * Init with raw value
     */
    public function __construct($value, bool $required=true)
    {
        $this->value = $value;
        $this->required = $required;
    }


    /**
     * Get original value
     */
    public function asIs()
    {
        return $this->value;
    }

    /**
     * Get value as boolean
     */
    public function asBool($default=null): ?bool
    {
        if (null === ($value = $this->prepareValue($default))) {
            return null;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    /**
     * Get value as int
     */
    public function asInt($default=null): ?int
    {
        if (null === ($value = $this->prepareValue($default))) {
            return null;
        }

        if (!is_numeric($value)) {
            throw Glitch::EUnexpectedValue(
                'Value is not numeric', null, $value
            );
        }

        return (int)$value;
    }

    /**
     * Get value as float
     */
    public function asFloat($default=null): ?float
    {
        if (null === ($value = $this->prepareValue($default))) {
            return null;
        }

        if (!is_numeric($value)) {
            throw Glitch::EUnexpectedValue(
                'Value is not numeric', null, $value
            );
        }

        return (float)$value;
    }

    /**
     * Get value as string
     */
    public function asString($default=null): ?string
    {
        if (null === ($value = $this->prepareValue($default))) {
            return null;
        }

        return (string)$value;
    }

    /**
     * Get value as slug string
     */
    public function asSlug($default=null): ?string
    {
        if (null === ($value = $this->prepareValue($default))) {
            return null;
        }

        $value = strtolower($value);

        if (!preg_match('/^[a-z0-9]([a-z0-9-_]*[a-z0-9])?$/', $value)) {
            throw Glitch::EUnexpectedValue(
                'Value is not a valid slug', null, $value
            );
        }

        return $value;
    }

    /**
     * Get value as Guid string
     */
    public function asGuid($default=null): ?string
    {
        if (null === ($value = $this->prepareValue($default))) {
            return null;
        }

        $value = strtolower($value);

        if (!preg_match('/^[a-z0-9]{8}-(?:[a-z0-9]{4}-){3}[a-z0-9]{12}$/', $value)) {
            throw Glitch::EUnexpectedValue(
                'Value is not a valid GUID', null, $value
            );
        }

        return $value;
    }

    /**
     * Prepare output value
     */
    protected function prepareValue($default=null)
    {
        $value = $this->value ?? $default;

        if ($value instanceof \Callback) {
            $value = $value();
        }

        if ($this->required && $value === null) {
            throw Glitch::EUnexpectedValue(
                'Value is required'
            );
        }

        return $value;
    }

    /**
     * Sanitize value using callback
     */
    public function with(callable $callback)
    {
        $value = $callback($this->value);

        if ($this->required && $value === null) {
            throw Glitch::EUnexpectedValue(
                'Value is required'
            );
        }

        return $value;
    }
}
