<?php

namespace Mperonnet\ReactEmail;

use Mperonnet\ReactEmail\DependencyInjection\ReactEmailExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ReactEmailBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new ReactEmailExtension();
        }

        return $this->extension ?: null;
    }

}