<?php

declare(strict_types=1);

namespace Mperonnet\ReactEmail;

final class ReactEmailContent
{
    public function __construct(
        public readonly string $html,
        public readonly string $text
    ) {
    }
}