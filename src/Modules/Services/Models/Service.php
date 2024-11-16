<?php

declare(strict_types=1);

namespace Modules\Services\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Modules\Services\Database\Factories\ServiceFactory;
use Modules\Services\ValueObjects\Service as ValueObjectService;

/**
 * @phpstan-import-type ServiceData from \Modules\Services\ValueObjects\Service
 *
 * @method ServiceData toArray()
 *
 * @property string $name
 * @property string $description
 */
class Service extends Model
{
    /** @use HasFactory<\Modules\Services\Database\Factories\ServiceFactory> */
    use HasFactory, Searchable, SoftDeletes;

    protected static function newFactory(): ServiceFactory
    {
        return ServiceFactory::new();
    }

    protected $fillable = [
        'name',
        'description',
        'contact',
        'address',
        'service_type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\Services\Models\ServiceEmail, $this>
     */
    public function emails(): HasMany
    {
        return $this->hasMany(ServiceEmail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\Services\Models\ServicePhone, $this>
     */
    public function phones(): HasMany
    {
        return $this->hasMany(ServicePhone::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Modules\Services\Models\ServiceCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\Services\Models\ServiceImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ServiceImage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\Services\Models\ServiceTag, $this>
     */
    public function tags(): HasMany
    {
        return $this->hasMany(ServiceTag::class);
    }

    public function getMains(): Service
    {
        return $this->append(['main_email', 'main_phone', 'main_image']);
    }

    /**
     * @return HasOne<ServiceEmail, $this>
     */
    public function mainEmail(): HasOne
    {
        return $this->hasOne(ServiceEmail::class)->where('is_main', true);
    }

    /**
     * @return HasOne<ServicePhone, $this>
     */
    public function mainPhone(): HasOne
    {
        return $this->hasOne(ServicePhone::class)->where('is_main', true);
    }

    /**
     * @return HasOne<ServiceImage, $this>
     */
    public function mainImage(): HasOne
    {
        return $this->hasOne(ServiceImage::class)->where('is_main', true);
    }

    public function toValueObject(): ValueObjectService
    {
        return new ValueObjectService($this->toArray());
    }
}
