<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    public $timestamps = true;

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('site_settings');
        });
        static::deleted(function () {
            Cache::forget('site_settings');
        });
    }

    public static function allToArray(): array
    {
        return Cache::remember('site_settings', 3600, function () {
            return static::query()
                ->get(['key', 'value'])
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public static function getValue(string $key, $default = null)
    {
        $all = static::allToArray();
        if (! array_key_exists($key, $all)) {
            return $default;
        }
        return $all[$key];
    }

    public static function setValue(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => (string) $value]);
        Cache::forget('site_settings');
    }
}
