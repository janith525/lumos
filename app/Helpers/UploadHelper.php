<?php

namespace App\Helpers;

use App\Models\TemporaryUpload;
use Illuminate\Support\Facades\Storage;

class UploadHelper
{
    /**
     * Resolve a temporary upload token and return the absolute file path on disk.
     *
     * @return string|null The absolute path to the file on disk, or null if invalid
     */
    public static function resolve(string $token): ?string
    {
        $temporaryUpload = TemporaryUpload::where('token', $token)->first();

        if (! $temporaryUpload) {
            return null;
        }

        $disk = Storage::disk('public');

        if ($disk->exists($temporaryUpload->path)) {
            return $disk->path($temporaryUpload->path);
        }

        return null;
    }

    /**
     * Delete the temporary upload file, folder, and database record.
     */
    public static function cleanup(string $token): bool
    {
        $temporaryUpload = TemporaryUpload::where('token', $token)->first();

        if (! $temporaryUpload) {
            return false;
        }

        $disk = Storage::disk('public');

        // Delete the entire folder dedicated to this temp upload
        if ($disk->exists($temporaryUpload->folder)) {
            $disk->deleteDirectory($temporaryUpload->folder);
        }

        $temporaryUpload->delete();

        return true;
    }
}
