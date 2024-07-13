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
    public const CONTEXT_HEADER = 'x-flucava-context';

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
            foreach ($headers as $header => $values) {
                if (strtolower($header) !== self::CONTEXT_HEADER) {
                    continue;
                }

                foreach ($values as $value) {
                    try {
                        $this->setContext(
                            $this->queryBus->handle(new LoadContextById($value))
                        );
                        break;
                    } catch (InvalidContextException) {

                    }
                }
            }
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
