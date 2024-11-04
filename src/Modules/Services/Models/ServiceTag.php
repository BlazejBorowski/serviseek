<?php

declare(strict_types=1);

namespace Modules\Services\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Services\Database\Factories\ServiceTagFactory;

/**
 * @property int $id
 * @property int $service_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class ServiceTag extends Model
{
    /** @use HasFactory<\Modules\Services\Database\Factories\ServiceTagFactory> */
    use HasFactory;

    protected static function newFactory(): ServiceTagFactory
    {
        return ServiceTagFactory::new();
    }

    protected $fillable = [
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Modules\Services\Models\Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
