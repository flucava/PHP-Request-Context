<?php

namespace Flucava\RequestContext\CommandHandler;

use Flucava\CqrsCore\Attribute\CommandHandler;
use Flucava\RequestContext\Model\Command\AddUri;
use Flucava\RequestContext\Model\Event\BeforeAddUri;
use InvalidArgumentException;

#[CommandHandler(command: AddUri::class)]
readonly class AddUriHandler extends AbstractHandler
{
    public function handle(object $action): ?object
    {
        if (!$action instanceof AddUri) {
            throw new InvalidArgumentException('Invalid command given.');
        }

        $this->eventDispatcher->dispatch(new BeforeAddUri($action));

        $this->ensureMainContext();

        $this->store(
            $this->filenameProvider->getUriFilename($action->getUri()),
            $action->getContext()
        );

        return null;
    }

}
