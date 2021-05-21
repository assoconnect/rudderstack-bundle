<?php

namespace AssoConnect\RudderstackBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class RudderstackExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('asc.rudderstack_write_key', $config['write_key']);
        $container->setParameter('asc.rudderstack_sources', $config['sources']??[]);
        $container->setParameter('asc.rudderstack_guest_id', $config['guest_id']);
        $container->setParameter('asc.rudderstack_env', $config['env']);
        $container->setParameter('asc.rudderstack_options', $config['options']);
    }
}
