<?php

namespace Flucava\RequestContext\CommandHandler;

use Flucava\RequestContext\Model\Command\AddUri;
use Flucava\RequestContext\Model\Event\BeforeAddUri;
use InvalidArgumentException;

/**
 * @author Philipp Marien
 */
readonly class AddUriHandler extends AbstractHandler
{
    public function handle(object $action): ?object
    {
        if (!$action instanceof AddUri) {
            throw new InvalidArgumentException('Invalid command given.');
        }

        $this->eventDispatcher->dispatch(new BeforeAddUri($action));

        $this->store(
            $this->filenameProvider->getUriFilename($action->getUri()),
            $action->getContext()
        );

        return null;
    }

}
