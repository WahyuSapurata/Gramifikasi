<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Akademik extends Model
{
    use HasFactory;

    protected $table = 'akademiks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'uuid_guru',
        'uuid_siswa',
        'uuid_mapel',
        'uuid_tahun',
        'kelas',
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
