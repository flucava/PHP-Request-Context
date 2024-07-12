<?php

namespace Flucava\RequestContext\CommandHandler;

use Flucava\CqrsCore\Attribute\CommandHandler;
use Flucava\RequestContext\Model\Command\VerifyInstanceManagerKey;
use Flucava\RequestContext\Model\Exception\InvalidInstanceManagerKeyException;
use InvalidArgumentException;

/**
 * @author Philipp Marien
 */
#[CommandHandler(command: VerifyInstanceManagerKey::class)]
readonly class VerifyInstanceManagerKeyHandler extends AbstractHandler
{
    /**
     * @throws \Throwable
     */
    public function handle(object $action): ?object
    {
        if (!$action instanceof VerifyInstanceManagerKey) {
            throw new InvalidArgumentException('Invalid command given.');
        }

        $this->ensureMainContext();

        $hash = $this->getContents($this->filenameProvider->getInstanceManagerKeyFilename());
        if (password_verify($action->getKey(), (string)$hash)) {
            return null;
        }

        throw new InvalidInstanceManagerKeyException();
    }
}
