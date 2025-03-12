<?php

namespace Mperonnet\ReactEmail\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class ReactEmailExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../config')
        );
        
        $loader->load('services.php');
        
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('react_email.template_directory', $config['template_directory']);
        $container->setParameter('react_email.node_path', $config['node_path']);
        $container->setParameter('react_email.tsx_path', $config['tsx_path']);
    }
    
    public function getAlias(): string
    {
        return 'react_email';
    }
}