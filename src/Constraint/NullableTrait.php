<?php
/**
 * This file is part of the Gadgets package
 * @license http://opensource.org/licenses/MIT
 */
declare(strict_types=1);
namespace DecodeLabs\Gadgets\Constraint;

trait NullableTrait
{
    protected $nullable = false;

    /**
     * Is this nullable?
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * Set nullable
     */
    public function setNullable(bool $nullable): Nullable
    {
        $this->nullable = $nullable;
        return $this;
    }
}
