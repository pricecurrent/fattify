<?php

namespace App\Diary\AI;

enum NutriDialogMessageType: string
{
    case SUGGESTION = 'suggestion';
    case CLARIFICATION = 'clarification';
}
