<?php

declare(strict_types=1);

namespace App\Services\ApiService\Enums;

enum ApiServiceStatusEnum: int
{
    case Pending = 1;
    case Completed = 3;
    case Failed = -1;
    case Cancelled = 0;
}
