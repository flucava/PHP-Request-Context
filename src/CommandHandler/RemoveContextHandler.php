<?php

namespace Flucava\RequestContext\CommandHandler;

use Flucava\CqrsCore\Attribute\CommandHandler;
use Flucava\RequestContext\Model\Command\RemoveContext;
use Flucava\RequestContext\Model\Event\BeforeRemoveContext;
use InvalidArgumentException;

#[CommandHandler(command: RemoveContext::class)]
readonly class RemoveContextHandler extends AbstractHandler
{
    public function handle(object $action): ?object
    {
        if (!$action instanceof RemoveContext) {
            throw new InvalidArgumentException('Invalid command given.');
        }

        $this->eventDispatcher->dispatch(new BeforeRemoveContext($action));

        $this->remove(
            $this->filenameProvider->getContextFilename($action->getUuid())
        );

        return null;
    }
}
