<?php

namespace Flucava\RequestContext\Service;

use Flucava\RequestContext\Model\View\Context;

/**
 * @author Philipp Marien
 */
class ContextProvider
{
    private ?Context $context = null;

    public function __construct(private readonly array $defaultSettings = [])
    {
    }

    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    public function isMasterContext(): bool
    {
        return is_null($this->context);
    }

    public function getContext(): Context
    {
        return $this->context ?? new Context(
            Context::MASTER_ID,
            Context::MASTER_NAME,
            $this->defaultSettings
        );
    }
}
