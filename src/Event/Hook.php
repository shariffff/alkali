<?php

declare(strict_types=1);

namespace Alkali\Event;

class Hook
{

    /**
     * The callback object holding the target callable
     * @var $callback
     */
    protected $callback;

    protected $callbackParamCount;

    /**
     * Create the new Hook instance
     * @param mixed $handle
     * @param mixed $priority
     * @return \Alkali\Event\Hook
     */
    public static function on($handle, $priority = 10): self
    {
        return new static($handle, $priority);
    }


    /**
     * Create the new Hook instance
     * @param string $handle   Action or Filter handle
     * @param int $priority     Priority
     */
    public function __construct(
        protected string $handle,
        protected int $priority = 10
    ) {}

    public function setCallback(callable $callback): self
    {
        $this->callback = $callback;
        return $this;
    }

    public function listen()
    {
        add_filter($this->handle, $this->callback, $this->priority, 100);
        return $this;
    }

    public function remove()
    {
        remove_filter($this->handle, $this->callback, $this->priority);
        return $this;
    }
}
