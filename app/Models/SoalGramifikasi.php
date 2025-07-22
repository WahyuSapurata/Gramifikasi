<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class SoalGramifikasi extends Model
{
    use HasFactory;

    protected $table = 'soal_gramifikasis';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'uuid_mapel',
        'uuid_misi',
        'soal',
        'jawaban',
        'jawaban_benar',
        'point',
    ];

    protected $casts = [
        'jawaban' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        // Event listener untuk membuat UUID sebelum menyimpan
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
