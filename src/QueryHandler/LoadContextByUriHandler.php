<?php

namespace Flucava\RequestContext\QueryHandler;

use Flucava\RequestContext\Model\Exception\InvalidContextException;
use Flucava\RequestContext\Model\Query\LoadContextById;
use Flucava\RequestContext\Model\Query\LoadContextByUri;
use Flucava\CqrsCore\Attribute\QueryHandler;
use Throwable;

#[QueryHandler(LoadContextByUri::class)]
readonly class LoadContextByUriHandler extends LoadContextByIdHandler
{
    /**
     * @param object $action
     * @return object|null
     * @throws InvalidContextException
     */
    public function handle(object $action): ?object
    {
        if (!$action instanceof LoadContextByUri) {
            return new InvalidContextException();
        }

        $uriFilename = $this->filenameProvider->getUriFilename($action->getUri());
        if (!file_exists($uriFilename)) {
            return new InvalidContextException();
        }

        try {
            // uri file only contains the plain context id
            return parent::handle(
                new LoadContextById(file_get_contents($uriFilename))
            );
        } catch (Throwable $e) {
            return new InvalidContextException($e);
        }
    }
}
