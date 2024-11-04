<?php

declare(strict_types=1);

namespace Modules\Services\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Services\Database\Factories\ServicePhoneFactory;

/**
 * @property int $id
 * @property int $service_id
 * @property string $number
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class ServicePhone extends Model
{
    /** @use HasFactory<\Modules\Services\Database\Factories\ServicePhoneFactory> */
    use HasFactory;

    protected static function newFactory(): ServicePhoneFactory
    {
        return ServicePhoneFactory::new();
    }

    protected $fillable = [
        'number',
        'description',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Modules\Services\Models\Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
