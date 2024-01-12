<?php

namespace App\Diary\AI;

enum AiSuggestionExceptionReason
{
    case INVALID_PROMPT;
    case NEEDS_CLARIFICATION;
    case INTERNAL_ERROR;
}
