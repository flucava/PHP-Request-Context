<?php

namespace Flucava\RequestContext\Model\Exception;

use RuntimeException;
use Throwable;

/**
 * @author Philipp Marien
 */
class InvalidInstanceManagerKeyException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid instance manager key provided.', 20240712234822);
    }
}
