<?php

namespace Flucava\RequestContext\CommandHandler;

use Flucava\RequestContext\Model\Command\RegisterContext;
use Flucava\RequestContext\Model\Event\BeforeRegisterContext;
use Flucava\CqrsCore\Attribute\CommandHandler;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

#[CommandHandler(RegisterContext::class)]
readonly class RegisterContextHandler extends AbstractHandler
{
    public function handle(object $action): ?object
    {
        if (!$action instanceof RegisterContext) {
            throw new InvalidArgumentException('Invalid command given.');
        }

        $this->eventDispatcher->dispatch(new BeforeRegisterContext($action));

        $this->ensureMainContext();

        try {
            $this->store(
                $this->filenameProvider->getContextFilename($action->getUuid()),
                json_encode([
                    'uuid' => $action->getUuid(),
                    'name' => $action->getName(),
                    'settings' => $action->getSettings(),
                ], JSON_THROW_ON_ERROR)
            );
        } catch (Throwable $exception) {
            throw  new RuntimeException('Failed to register context.', 20240611123356, $exception);
        }

        return null;
    }
}
