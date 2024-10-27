<?php

declare(strict_types=1);

namespace Modules\Services\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Service extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    protected static function newFactory()
    {
        return \Modules\Services\Database\Factories\ServiceFactory::new();
    }

    protected $fillable = [
        'name',
        'description',
        'contact',
        'address',
        'service_type',
    ];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'service_type' => $this->service_type,
        ];
    }

    public function emails()
    {
        return $this->hasMany(ServiceEmail::class);
    }

    public function phones()
    {
        return $this->hasMany(ServicePhone::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }
}
