<?php

namespace Flucava\RequestContext\Model\Query;

use Flucava\CqrsCore\Attribute\Query;

#[Query]
readonly class LoadContextById
{
    public function __construct(private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
