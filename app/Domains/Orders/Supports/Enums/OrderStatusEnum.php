<?php

declare(strict_types=1);

namespace App\Domains\Orders\Supports\Enums;

enum OrderStatusEnum: string
{
    case Draft = 'draft';
    case Processing = 'processing';
    case Successful = 'successful';
    case Failed = 'failed';
    case Cancelled = 'cancelled';
}
