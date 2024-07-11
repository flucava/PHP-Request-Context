<?php

namespace Flucava\RequestContext\Model\Event;

use Flucava\RequestContext\Model\Command\RegisterContext;

/**
 * @author Philipp Marien
 */
readonly class BeforeRegisterContext
{
    public function __construct(private RegisterContext $command)
    {
    }

    public function getCommand(): RegisterContext
    {
        return $this->command;
    }
}
