<?php

namespace Flucava\RequestContext\QueryHandler;

use Flucava\RequestContext\Model\Exception\InvalidContextException;
use Flucava\RequestContext\Model\Query\LoadContextById;
use Flucava\RequestContext\Model\Query\LoadContextByUri;
use Flucava\CqrsCore\Attribute\QueryHandler;
use Flucava\RequestContext\Model\View\Context;
use Flucava\RequestContext\Service\FilenameProvider;
use Psr\Http\Message\UriFactoryInterface;
use Throwable;

#[QueryHandler(LoadContextByUri::class)]
readonly class LoadContextByUriHandler extends LoadContextByIdHandler
{
    public function __construct(
        private UriFactoryInterface $uriFactory,
        FilenameProvider $filenameProvider,
        private array $masterUris = [],
        array $defaultSettings = [],
    ) {
        parent::__construct($filenameProvider, $defaultSettings);
    }

    /**
     * @param object $action
     * @return object|null
     * @throws InvalidContextException
     */
    public function handle(object $action): ?object
    {
        if (!$action instanceof LoadContextByUri) {
            throw new InvalidContextException();
        }

        $uriFilename = $this->filenameProvider->getUriFilename($action->getUri());
        $contextId = null;
        if (file_exists($uriFilename)) {
            // uri file only contains the plain context id
            $contextId = file_get_contents($uriFilename);
        } else {
            $uri = strtolower($this->uriFactory->createUri($action->getUri())->getHost());
            if (in_array($uri, $this->masterUris, true)) {
                $contextId = Context::MASTER_ID;
            };
        }

        if (!$contextId) {
            throw new InvalidContextException();
        }

        try {
            return parent::handle(
                new LoadContextById($contextId)
            );
        } catch (Throwable $e) {
            throw new InvalidContextException($e);
        }
    }
}
