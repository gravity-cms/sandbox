<?php

namespace Gravity\AdminBundle;

use Gravity\AdminBundle\DependencyInjection\Compiler\ThemeCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GravityAdminBundle extends Bundle
{
    /**
     * @var string
     */
    protected $parent;

    /**
     * @param string $parent
     */
    function __construct($parent)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ThemeCompilerPass());
    }

}
