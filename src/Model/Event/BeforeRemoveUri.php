<?php

namespace Flucava\RequestContext\Model\Event;

use Flucava\RequestContext\Model\Command\RemoveUri;

/**
 * @author Philipp Marien
 */
readonly class BeforeRemoveUri
{
    public function __construct(private RemoveUri $command)
    {
    }

    public function getCommand(): RemoveUri
    {
        return $this->command;
    }
}
