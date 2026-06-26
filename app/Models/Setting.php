<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Parse the given URL, replacing {{SITE_URL}} with the active application root URL.
     */
    public static function parseUrl(?string $url): string
    {
        if (empty($url)) {
            return '#';
        }

        $siteUrl = rtrim(url('/'), '/');
        $resolved = str_replace('{{SITE_URL}}', $siteUrl, $url);

        if (preg_match('/^www\./i', $resolved)) {
            $resolved = 'https://'.$resolved;
        }

        if (! preg_match('/^(https?:\/\/|\/|#)/i', $resolved) && str_contains($resolved, '.')) {
            $resolved = 'https://'.$resolved;
        }

        if (! preg_match('/^(https?:\/\/|\/|#)/i', $resolved)) {
            $resolved = '/'.$resolved;
        }

        return $resolved;
    }
}
