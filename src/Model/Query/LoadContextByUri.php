<?php

namespace Flucava\RequestContext\Model\Query;

use Flucava\CqrsCore\Attribute\Query;

#[Query]
readonly class LoadContextByUri
{
    public function __construct(private string $uri)
    {
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
