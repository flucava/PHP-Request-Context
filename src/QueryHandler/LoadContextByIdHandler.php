<?php

namespace Flucava\RequestContext\QueryHandler;

use Flucava\RequestContext\Model\Exception\InvalidContextException;
use Flucava\RequestContext\Model\Query\LoadContextById;
use Flucava\RequestContext\Model\View\Context;
use Flucava\RequestContext\Service\FilenameProvider;
use Flucava\CqrsCore\Attribute\QueryHandler;
use Flucava\CqrsCore\HandlerInterface;
use Throwable;

#[QueryHandler(LoadContextById::class)]
readonly class LoadContextByIdHandler implements HandlerInterface
{
    public function __construct(
        protected FilenameProvider $filenameProvider,
        private array $defaultSettings = []
    ) {
    }

    /**
     * @param object $action
     * @return object|null
     * @throws InvalidContextException
     */
    public function handle(object $action): ?object
    {
        if (!$action instanceof LoadContextById) {
            throw new InvalidContextException();
        }

        try {
            $contextFile = $this->filenameProvider->getContextFilename($action->getId());
            if (!file_exists($contextFile)) {
                if ($action->getId() === Context::MAIN_ID) {
                    return new Context(
                        Context::MAIN_ID,
                        Context::MAIN_NAME,
                        $this->defaultSettings
                    );
                }

                throw new InvalidContextException();
            }

            $context = json_decode(
                file_get_contents($contextFile),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            return new Context(
                $action->getId(),
                $context['name'],
                array_merge_recursive($context['settings'], $this->defaultSettings)
            );
        } catch (Throwable $e) {
            throw new InvalidContextException($e);
        }
    }
}
