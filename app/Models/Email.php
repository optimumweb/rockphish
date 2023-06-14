<?php

namespace App\Models;

use App\Mail\CampaignEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Email extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'target',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
        'hooked_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $email) {
            $email->uuid = Str::uuid();
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

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function send(bool $save = true): void
    {
        if (! isset($this->target)) {
            throw new \Exception("No target defined for Email '{$this}'");
        }

        Mail::to($this->target)->send(new CampaignEmail($this));

        $this->sent_at = now();

        if ($save) {
            $this->saveOrFail();
        }
    }

    public function open(bool $save = true): void
    {
        $this->opened_at = now();

        if ($save) {
            $this->saveOrFail();
        }
    }

    public function hook(bool $save = true): void
    {
        $this->hooked_at = now();

        if ($save) {
            $this->saveOrFail();
        }
    }
}
