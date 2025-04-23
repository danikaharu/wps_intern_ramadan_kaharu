<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'activity', 'photo', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        if ($this->status == 0) {
            return 'Pending';
        } elseif ($this->status == 1) {
            return 'Disetujui Atasan';
        } else {
            return 'Ditolak Atasan';
        }
    }
}
