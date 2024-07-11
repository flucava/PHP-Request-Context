<?php

namespace Flucava\RequestContext\Model\Command;

use Flucava\CqrsCore\Attribute\Command;

#[Command]
readonly class RegisterContext
{
    public function __construct(
        private string $uuid,
        private string $name,
        private array $settings,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }
}
