<?php

namespace Flucava\RequestContext\Service;

use Flucava\CqrsCore\Query\QueryBus;
use Flucava\RequestContext\Model\Exception\InvalidContextException;
use Flucava\RequestContext\Model\Query\LoadContextById;
use Flucava\RequestContext\Model\Query\LoadContextByUri;
use Flucava\RequestContext\Model\View\Context;
use RuntimeException;

/**
 * @author Philipp Marien
 */
class ContextProvider
{
    private ?Context $context = null;

    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    /**
     * @throws \Throwable
     */
    public function loadContext(string $uri, array $headers = []): void
    {
        try {
            $this->setContext(
                $this->queryBus->handle(new LoadContextByUri($uri))
            );
        } catch (InvalidContextException) {
            foreach ($headers as $header => $value) {
                if (strtolower($header) !== 'x-flucava-request-context') {
                    continue;
                }

                try {
                    $this->setContext(
                        $this->queryBus->handle(new LoadContextById($value))
                    );
                    break;
                } catch (InvalidContextException) {

                }
            }
        }

        if (!$this->context) {
            throw new InvalidContextException();
        }
    }

    public function setContext(Context $context): void
    {
        if ($this->context) {
            throw new RuntimeException('Context already set', 20240712175459);
        }

        $this->context = $context;
    }

    public function getContext(): Context
    {
        if (!$this->context) {
            throw new InvalidContextException(
                new RuntimeException(
                    'Context has not been loaded yet. Call method "ContextProvider::loadContext" first.',
                    20240712175345
                )
            );
        }

        return $this->context;
    }
}
