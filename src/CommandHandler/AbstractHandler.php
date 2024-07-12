<?php

namespace Flucava\RequestContext\CommandHandler;

use Flucava\RequestContext\Model\Exception\InvalidContextException;
use Flucava\RequestContext\Model\View\Context;
use Flucava\RequestContext\Service\ContextProvider;
use Flucava\RequestContext\Service\FilenameProvider;
use Flucava\CqrsCore\HandlerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @author Philipp Marien
 */
readonly abstract class AbstractHandler implements HandlerInterface
{
    public function __construct(
        protected EventDispatcherInterface $eventDispatcher,
        protected FilenameProvider $filenameProvider,
        protected ContextProvider $contextProvider,
    ) {
    }

    protected function ensureMainContext(): void
    {
        if (!$this->contextProvider->getContext()->isMainContext()) {
            throw new InvalidContextException();
        }
    }

    protected function store(string $filename, string $content): void
    {
        file_put_contents($filename, $content);
    }

    protected function getContents(string $filename): ?string
    {
        if (!file_exists($filename)) {
            return null;
        }

        return file_get_contents($filename);
    }

    protected function remove(string $filename): void
    {
        unlink($filename);
    }
}
