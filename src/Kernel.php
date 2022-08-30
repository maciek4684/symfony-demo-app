<?php

namespace App;

use App\Strategy\TaskEvaluatorCompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        // adding strategies for code evaluation
        $container->addCompilerPass(new TaskEvaluatorCompilerPass());
    }
}
