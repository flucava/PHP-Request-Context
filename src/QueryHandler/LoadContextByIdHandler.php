<?php

namespace Flucava\RequestContext\QueryHandler;

use Flucava\RequestContext\Model\Exception\InvalidContextException;
use Flucava\RequestContext\Model\Query\LoadContextById;
use Flucava\RequestContext\Model\Query\LoadContextByUri;
use Flucava\RequestContext\Model\View\Context;
use Flucava\RequestContext\Service\FilenameProvider;
use Flucava\CqrsCore\Attribute\QueryHandler;
use Flucava\CqrsCore\HandlerInterface;
use Throwable;

#[QueryHandler(LoadContextByUri::class)]
readonly class LoadContextByIdHandler implements HandlerInterface
{
    public function __construct(protected FilenameProvider $filenameProvider)
    {
    }

    /**
     * @param object $action
     * @return object|null
     * @throws InvalidContextException
     */
    public function handle(object $action): ?object
    {
        if (!$action instanceof LoadContextById) {
            return new InvalidContextException();
        }

        try {
            $context = json_decode(
                file_get_contents($this->filenameProvider->getContextFilename($action->getId())),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            return new Context($action->getId(), $context['name'], $context['settings']);
        } catch (Throwable $e) {
            return new InvalidContextException($e);
        }
    }
}
