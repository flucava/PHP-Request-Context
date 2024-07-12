<?php

namespace Flucava\RequestContext\CommandHandler;

use Flucava\CqrsCore\Attribute\CommandHandler;
use Flucava\CqrsCore\HandlerInterface;
use Flucava\RequestContext\Model\Command\GenerateInstanceManagerKey;
use Flucava\RequestContext\Model\Result\InstanceManagerKey;
use Flucava\RequestContext\Service\FilenameProvider;
use InvalidArgumentException;
use RuntimeException;

/**
 * @author Philipp Marien
 */
#[CommandHandler(command: GenerateInstanceManagerKey::class)]
readonly class GenerateInstanceManagerKeyHandler extends AbstractHandler
{
    /**
     * @throws \Throwable
     */
    public function handle(object $action): ?object
    {
        if (!$action instanceof GenerateInstanceManagerKey) {
            throw new InvalidArgumentException('Invalid command given.');
        }

        $this->ensureMainContext();

        $filename = $this->filenameProvider->getInstanceManagerKeyFilename();

        if (file_exists($filename) && !$action->isOverwriteAllowed()) {
            throw new RuntimeException('Instance Manager key already exists.', 20240713000250);
        }

        $key = bin2hex(random_bytes(128)); //strlen: 256

        $this->store($filename, password_hash($key, PASSWORD_DEFAULT));

        return new InstanceManagerKey($key);
    }
}
