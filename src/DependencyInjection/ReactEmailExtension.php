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
        
        // Allow overriding config with environment variables
        $templateDirectory = $config['template_directory'] ?? $_ENV['REACT_EMAIL_DIRECTORY'];
        $nodePath = $config['node_path'] ?? $_ENV['REACT_EMAIL_NODE_PATH'];
        $tsxPath = $config['tsx_path'] ?? $_ENV['REACT_EMAIL_TSX_PATH'];
        
        $container->setParameter('react_email.template_directory', $templateDirectory);
        $container->setParameter('react_email.node_path', $nodePath);
        $container->setParameter('react_email.tsx_path', $tsxPath);
    }
    
    public function getAlias(): string
    {
        return 'react_email';
    }
}