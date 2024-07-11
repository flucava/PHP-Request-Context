<?php

namespace Flucava\RequestContext\Model\Command;

use Flucava\CqrsCore\Attribute\Command;

#[Command]
readonly class RemoveUri
{
    public function __construct(
        private string $uri
    ) {
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
