<?php

namespace Flucava\RequestContext\CommandHandler;

use Flucava\CqrsCore\Attribute\CommandHandler;
use Flucava\RequestContext\Model\Command\RemoveUri;
use Flucava\RequestContext\Model\Event\BeforeRemoveUri;
use InvalidArgumentException;

#[CommandHandler(command: RemoveUri::class)]
readonly class RemoveUriHandler extends AbstractHandler
{
    public function handle(object $action): ?object
    {
        if (!$action instanceof RemoveUri) {
            throw new InvalidArgumentException('Invalid command given.');
        }

        $this->eventDispatcher->dispatch(new BeforeRemoveUri($action));

        $this->ensureMainContext();

        $this->remove(
            $this->filenameProvider->getUriFilename($action->getUri())
        );

        return null;
    }
}
