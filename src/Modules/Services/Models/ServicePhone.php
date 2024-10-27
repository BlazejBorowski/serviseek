<?php

declare(strict_types=1);

namespace Modules\Services\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePhone extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Modules\Services\Database\Factories\ServicePhoneFactory::new();
    }

    protected $fillable = [
        'number',
        'description',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
