<?php

namespace Flucava\RequestContext\Model\Command;

use Flucava\CqrsCore\Attribute\Command;

#[Command]
readonly class RemoveContext
{
    public function __construct(private string $uuid)
    {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
