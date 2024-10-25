<?php

declare(strict_types=1);

namespace App\Exceptions;

class UserException extends InternalException
{
    public static function missingAuthenticatedUser(
        string $message = 'Unauthorized action.',
        int $code = 403
    ): UserException {
        return new self($message, $code);
    }
}
