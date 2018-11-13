<?php

namespace BileMo\AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ExceptionNormalizerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $exceptionListenerDefinition = $container->findDefinition('bile_mo_app.exception_subscriber');
        $normalizers = $container->findTaggedServiceIds('bilemo_app.normalizer');

        foreach (array_keys($normalizers) as $normalizerId) {
            $exceptionListenerDefinition->addMethodCall('addNormalizer', [new Reference($normalizerId)]);
        }
    }
}