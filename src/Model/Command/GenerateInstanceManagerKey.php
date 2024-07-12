<?php

namespace Flucava\RequestContext\Model\Command;

use Flucava\CqrsCore\Attribute\Command;
use Flucava\RequestContext\Model\Result\InstanceManagerKey;

/**
 * @author Philipp Marien
 */
#[Command(resultRequired: true, resultClass: InstanceManagerKey::class)]
readonly class GenerateInstanceManagerKey
{
    public function __construct(private bool $allowOverwrite)
    {
    }

    public function isOverwriteAllowed(): bool
    {
        return $this->allowOverwrite;
    }
}
