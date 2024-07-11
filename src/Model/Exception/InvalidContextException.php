<?php

namespace Flucava\RequestContext\Model\Exception;

use RuntimeException;
use Throwable;

/**
 * @author Philipp Marien
 */
class InvalidContextException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Application has been called with an invalid context.', 20240611012614, $previous);
    }
}
