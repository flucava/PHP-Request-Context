<?php

namespace Flucava\RequestContext\Model\View;

/**
 * @author Philipp Marien
 */
readonly class Context
{
    public const string MAIN_ID = '00000000-0000-0000-0000-000000000000';
    public const string MAIN_NAME = 'MAIN CONTEXT';

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
