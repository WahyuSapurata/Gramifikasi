<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absens';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'uuid_akademik',
        'tanggal',
        'status',
        'keterangan',
    ];

    public function akademik()
    {
        return $this->belongsTo(Akademik::class, 'uuid_akademik', 'uuid');
    }

    protected static function boot()
    {
        parent::boot();

        // Event listener untuk membuat UUID sebelum menyimpan
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
