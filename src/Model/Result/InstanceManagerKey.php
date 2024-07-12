<?php

namespace Flucava\RequestContext\Model\Result;

/**
 * @author Philipp Marien
 */
readonly class InstanceManagerKey
{
    public function __construct(private string $key)
    {
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
