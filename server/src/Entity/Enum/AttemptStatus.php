<?php declare(strict_types=1);

namespace App\Entity\Enum;

enum AttemptStatus : string
{
    case InProgress = 'in_progress';
    case Success = 'success';
    case Failure = 'failure';
}
