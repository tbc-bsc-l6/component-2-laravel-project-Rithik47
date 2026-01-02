<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrolment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'module_id', 'started_at', 'status', 'completed_at'];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PASS = 'pass';
    public const STATUS_FAIL = 'fail';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
    //
}
