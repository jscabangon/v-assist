<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'todo',
        'description',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'create_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
