<?php

namespace Flucava\RequestContext\Model\Command;

use Flucava\CqrsCore\Attribute\Command;

#[Command]
readonly class AddUri
{
    public function __construct(
        private string $uri,
        private string $context,
    ) {
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getContext(): string
    {
        return $this->context;
    }

}
