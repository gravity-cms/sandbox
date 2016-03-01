<?php


namespace Gravity\CmsBundle\Display;

use Gravity\CmsBundle\Display\Handler\DisplayHandlerInterface;
use Gravity\CmsBundle\Display\Type\DisplayDefinitionInterface;
use Gravity\CmsBundle\Entity\Node;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DisplayManager
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class DisplayManager
{
    /**
     * @var DisplayHandlerInterface[]
     */
    protected $handlers = [];

    /**
     * @var DisplayDefinitionInterface[]
     */
    protected $definitions = [];

    /**
     * @var array
     */
    protected $config;

    /**
     * DisplayManager constructor.
     *
     * @param DisplayHandlerInterface[]    $handlers
     * @param DisplayDefinitionInterface[] $definitions
     * @param array                        $config
     */
    public function __construct(array $handlers, array $definitions, array $config)
    {
        foreach ($handlers as $handler) {
            $this->handlers[$handler->getName()] = $handler;
        }

        foreach ($definitions as $definition) {
            $this->definitions[$definition->getName()] = $definition;
        }

        $this->config      = $config;
    }

    /**
     * Get the display config for the node class
     *
     * @param string $nodeClass
     *
     * @return array
     */
    public function getNodeConfig($nodeClass)
    {
        $config          = $this->config[$nodeClass];
        $optionsResolver = new OptionsResolver();
        $handler = $this->handlers[$config['handler']];
        $handler->setOptions($optionsResolver, $config['options']);

        $config['options'] = $optionsResolver->resolve($config['options']);

        return $config;
    }

    /**
     * @param DisplayHandlerInterface $handler
     * @param Node                    $node
     *
     * @deprecated use DisplayManager::getNodeConfig
     *
     * @return array
     */
    public function getHandlerOptions(DisplayHandlerInterface $handler, Node $node)
    {
        $config          = $this->getNodeConfig(get_class($node));
        $optionsResolver = new OptionsResolver();
        $handler->setOptions($optionsResolver, $config['options']);

        return $optionsResolver->resolve($config['options']);
    }

    /**
     * @return DisplayHandlerInterface
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * @param string $name
     *
     * @return DisplayHandlerInterface
     */
    public function getHandler($name)
    {
        return $this->handlers[$name];
    }

    /**
     * @param Node $node
     *
     * @return DisplayHandlerInterface
     */
    public function getHandlerForNode(Node $node)
    {
        $config = $this->getNodeConfig(get_class($node));

        return $this->handlers[$config['handler']];
    }


    /**
     * @return DisplayDefinitionInterface[]
     */
    public function getFieldDisplayDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @param string $name
     *
     * @return DisplayDefinitionInterface
     */
    public function getDisplayDefinition($name)
    {
        return $this->definitions[$name];
    }
}
