<?php

namespace Flucava\RequestContext\Model\Event;

use Flucava\RequestContext\Model\Command\AddUri;

/**
 * @author Philipp Marien
 */
readonly class BeforeAddUri
{
    public function __construct(private AddUri $command)
    {
    }

    public function getCommand(): AddUri
    {
        return $this->command;
    }
}
