<?php

namespace App\Strategy;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

// https://symfony.com/doc/current/service_container/tags.html

class TaskEvaluatorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $resolverService = $container->findDefinition(TaskEvaluator::class);

        $strategyServices = array_keys($container->findTaggedServiceIds(EvaluationStrategyInterface::SERVICE_TAG));

        foreach ($strategyServices as $strategyService) {
            $resolverService->addMethodCall('addStrategy', [new Reference($strategyService)]);
        }
    }
}
