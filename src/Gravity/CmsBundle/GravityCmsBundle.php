<?php

namespace Gravity\CmsBundle;

use Gravity\CmsBundle\DependencyInjection\Compiler as Compilers;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GravityCmsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new Compilers\FieldCompilerPass());
        $container->addCompilerPass(new Compilers\SearchCompilerPass());
    }
}
