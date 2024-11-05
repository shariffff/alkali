<?php

declare(strict_types=1);

namespace Alkali\Support;

class Callback
{
    /**
     * The normalized callable.
     * @var mixed
     */
    protected $target;
    public function __construct(callable $target)
    {
        $this->target = $target;
    }
    public function call()
    {
        return $this->target;
    }
}
