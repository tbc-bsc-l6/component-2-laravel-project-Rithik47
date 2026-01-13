<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Enrolment;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Module extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'is_archived',
    ];

    /**
     * The attribute casts.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_archived' => 'boolean',
    ];

    public function enrolments(): HasMany
    {
        return $this->hasMany(Enrolment::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrolments')
                    ->withPivot(['started_at', 'status', 'completed_at'])
                    ->withTimestamps();
    }

    public function teacher(): BelongsTo|null
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function activeStudentsCount(): int
    {
        return $this->enrolments()->whereNull('completed_at')->count();
    }
}
