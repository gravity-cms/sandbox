<?php

namespace Gravity\CmsBundle\Search\Handler;

/**
 * Class HandlerManager
 *
 * @package Gravity\CmsBundle\Search\Handler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class HandlerManager
{
    /**
     * @var HandlerInterface[]
     */
    protected $handlers = [];

    /**
     * @return HandlerInterface[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * @param $name
     *
     * @return HandlerInterface
     */
    public function getHandler($name)
    {
        return $this->handlers[$name];
    }

    /**
     * @param HandlerInterface[] $handlers
     */
    public function setHandlers($handlers)
    {
        foreach($handlers as $handler) {
            $this->handlers[$handler->getName()] = $handler;
        }
    }

}
