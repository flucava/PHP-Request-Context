<?php

namespace Flucava\RequestContext\Model\Event;

use Flucava\RequestContext\Model\Command\RemoveContext;

/**
 * @author Philipp Marien
 */
readonly class BeforeRemoveContext
{
    public function __construct(private RemoveContext $command)
    {
    }

    public function getCommand(): RemoveContext
    {
        return $this->command;
    }
}
