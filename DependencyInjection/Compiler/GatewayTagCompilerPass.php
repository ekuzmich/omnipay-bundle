<?php

/*
 * This file is part of the colinodell\omnipay-bundle package.
 *
 * (c) 2015 Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ColinODell\OmnipayBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GatewayTagCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('omnipay')) {
            return;
        }

        $definition = $container->findDefinition('omnipay');

        $taggedGateways = $container->findTaggedServiceIds('omnipay.gateway');
        foreach ($taggedGateways as $id => $tags) {
            $definition->addMethodCall('registerGateway', [new Reference($id)]);
        }
    }
}
