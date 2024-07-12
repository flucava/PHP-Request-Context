<?php

namespace Flucava\RequestContext\Model\Command;

use Flucava\CqrsCore\Attribute\Command;

/**
 * @author Philipp Marien
 */
#[Command]
readonly class VerifyInstanceManagerKey
{
    public function __construct(private string $key)
    {
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
