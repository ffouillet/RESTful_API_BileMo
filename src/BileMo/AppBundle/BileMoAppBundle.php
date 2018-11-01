<?php

namespace BileMo\AppBundle;

use BileMo\AppBundle\DependencyInjection\Compiler\ExceptionNormalizerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BileMoAppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ExceptionNormalizerPass());
    }
}
