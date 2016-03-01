<?php

namespace Gravity\CmsBundle;

use Gravity\CmsBundle\DependencyInjection\Compiler as Compilers;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class GravityCmsBundle
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class GravityCmsBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new Compilers\FieldCompilerPass());
        $container->addCompilerPass(new Compilers\SearchCompilerPass());
        $container->addCompilerPass(new Compilers\RoutingCompilerPass());
        $container->addCompilerPass(new Compilers\DisplayCompilerPass());
    }
}
