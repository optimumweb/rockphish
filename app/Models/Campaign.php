<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'subject',
        'body',
        'domain',
        'from_address',
        'from_name',
        'reply_to',
        'hooked_title',
        'hooked_body',
        'targets',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $campaign) {
            $campaign->uuid = Str::uuid();

            if ($currentUser = auth()->user()) {
                if (isset($currentUser->account)) {
                    $this->account()->associate($currentUser->account);
                }
            }
        });
    }

    public function __toString()
    {
        return "{$this->uuid}";
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getTargetsAttribute(): Collection
    {
        $targets = $this->attributes['targets'];
        $targets = str_replace([',', ';'], PHP_EOL, $targets);
        $targets = explode(PHP_EOL, $targets);
        $targets = array_map('trim', $targets);
        return collect($targets);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }
}
