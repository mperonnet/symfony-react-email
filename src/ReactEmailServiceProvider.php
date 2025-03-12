<?php

namespace Mperonnet\ReactEmail;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ReactEmailBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}