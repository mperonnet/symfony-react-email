<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Mperonnet\ReactEmail\Renderer;
use Mperonnet\ReactEmail\ReactEmailFactory;

return function(ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();
        
    $services->set(Renderer::class)
        ->public();
        
    $services->set(ReactEmailFactory::class)
        ->public();
};