<?php

declare(strict_types=1);

namespace App\Domains\Orders\Models;

use App\Domains\Orders\Supports\Enums\OrderStatusEnum;
use App\Domains\Users\Models\User;
use App\Services\Supports\Traits\WithFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string          $uuid
 * @property OrderStatusEnum $status
 * @property string          $owner_uuid
 *
 * @property Carbon          $created_at
 * @property Carbon          $updated_at
 *
 * @property-read User       $owner
 */
class Order extends Model
{
    use WithFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'status',
        'owner_uuid',
    ];

    protected $casts = [
      'status' => OrderStatusEnum::class,
    ];

    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'uuid', 'owner_uuid');
    }
}
