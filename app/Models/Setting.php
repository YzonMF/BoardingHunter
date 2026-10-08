<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Key/value site settings stored in the database. Anything an admin has not
 * set falls back to the defaults below, so a fresh install works out of the box.
 */
class Setting extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    public const CREATED_AT = null;

    protected $fillable = ['key', 'value'];

    private const CONTAINER_KEY = 'site.settings';

    public static function defaults(): array
    {
        return [
            'site_name' => 'Boarding Hunter',
            'contact_email' => 'boardinghunter@example.com',
            'contact_phone' => '',
            'address' => '',
            'about_text' => 'Boarding Hunter connects room owners with people looking for a place to stay. '
                . 'Browse rooms, message owners, reserve or book, and share your experience.',
            'currency_symbol' => '₱',
            'reservation_hold_days' => '7',
            'home_tagline' => 'Find a room that fits you.',
            'home_latest_count' => '6',
            'posts_per_page' => '10',
            'max_photos_per_upload' => '10',
            'max_photo_mb' => '4',
        ];
    }

    /** All settings, with defaults filled in for anything not stored. */
    public static function values(): array
    {
        // Cached in the container for the current request/app instance only.
        if (!app()->bound(self::CONTAINER_KEY)) {
            app()->instance(self::CONTAINER_KEY, array_merge(self::defaults(), static::query()->pluck('value', 'key')->map(fn ($v) => $v ?? '')->all()));
        }

        return app(self::CONTAINER_KEY);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::values()[$key] ?? $default;
    }

    /** A numeric setting, clamped to a sane range so a bad stored value cannot break a page. */
    public static function int(string $key, int $default, int $min = 1, int $max = 1000): int
    {
        $value = (int) self::get($key, $default);

        return max($min, min($max, $value ?: $default));
    }

    /** Saves several settings at once; unknown keys are ignored. */
    public static function put(array $values): void
    {
        foreach (array_intersect_key($values, self::defaults()) as $key => $value) {
            static::query()->updateOrInsert(['key' => $key], ['value' => (string) ($value ?? ''), 'updated_at' => now()]);
        }

        self::forget();
    }

    public static function forget(): void
    {
        app()->forgetInstance(self::CONTAINER_KEY);
    }

    /** Formats an amount with the configured currency symbol, e.g. "₱1,250.00". */
    public static function money(float|int|string|null $amount): string
    {
        $symbol = (string) self::get('currency_symbol');

        // Letter-based symbols (PHP, USD) read better with a space: "PHP 450.00".
        $gap = $symbol !== '' && ctype_alpha(substr($symbol, -1)) ? ' ' : '';

        return $symbol . $gap . number_format((float) $amount, 2);
    }
}
