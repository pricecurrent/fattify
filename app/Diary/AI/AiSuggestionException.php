<?php

namespace App\Diary\AI;

use Exception;

class AiSuggestionException extends Exception
{
    public function __construct(
        string $message,
        public readonly AiSuggestionExceptionReason $reason,
    ) {
        parent::__construct($message);
    }

    public static function invalidPrompt($message)
    {
        return new static($message, AiSuggestionExceptionReason::INVALID_PROMPT);
    }

    public static function needsClarification($message)
    {
        return new static($message, AiSuggestionExceptionReason::NEEDS_CLARIFICATION);
    }

    public static function internalError($message)
    {
        return new static($message, AiSuggestionExceptionReason::INTERNAL_ERROR);
    }
}
