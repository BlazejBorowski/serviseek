<?php

declare(strict_types=1);

namespace Modules\Services\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceEmail extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Modules\Services\Database\Factories\ServiceEmailFactory::new();
    }

    protected $fillable = [
        'email',
        'description',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
