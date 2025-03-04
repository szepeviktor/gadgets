<?php
/**
 * This file is part of the Gadgets package
 * @license http://opensource.org/licenses/MIT
 */
declare(strict_types=1);
namespace DecodeLabs\Gadgets;

interface Then
{
    public function then(callable $callback): Then;
    public function thenEach(array $values, callable $callback): Then;
    public function thenWhen($truth, callable $yes, callable $no=null): Then;
    public function thenUnless($truth, callable $no, callable $yes=null): Then;
}
