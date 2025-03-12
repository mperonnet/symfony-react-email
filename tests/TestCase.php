<?php

use Mperonnet\ReactEmail\ReactEmailServiceProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected ParameterBag $params;
    protected ContainerBuilder $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->params = new ParameterBag([
            'react_email.template_directory' => __DIR__ . '/emails',
            'react_email.node_path' => exec('which node'),
            'react_email.tsx_path' => __DIR__ . '/../node_modules/tsx/dist/cli.mjs',
        ]);

        $this->container = new ContainerBuilder($this->params);
    }
}