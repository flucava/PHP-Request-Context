<?php

namespace Flucava\RequestContext\Service;

use Psr\Http\Message\UriFactoryInterface;

/**
 * @author Philipp Marien
 */
readonly class FilenameProvider
{
    public function __construct(
        private string $storage,
        private UriFactoryInterface $uriFactory
    ) {
    }

    public function getUriFilename(string $uri): string
    {
        return rtrim($this->storage, '/') . '/uri__' . strtolower($this->uriFactory->createUri($uri)->getHost());
    }

    public function getContextFilename(string $uuid): string
    {
        return rtrim($this->storage, '/') . '/context__' . strtolower(trim($uuid)) . '.json';
    }
}
