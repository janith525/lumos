<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\TemporaryUpload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Process an asynchronous temporary file upload from FilePond.
     */
    public function process(Request $request): Response
    {
        // Dynamically find the first uploaded file in the request
        $file = collect($request->allFiles())->first();

        if (is_array($file)) {
            $file = head($file);
        }

        if (! $file) {
            return response('No file uploaded.', 400);
        }

        $token = (string) Str::uuid();
        $folder = 'temp/'.$token;
        $filename = $file->getClientOriginalName();

        // Store the file in our public storage folder temp directory
        $path = $file->storeAs($folder, $filename, 'public');

        // Log the file details in the database
        TemporaryUpload::create([
            'token' => $token,
            'folder' => $folder,
            'filename' => $filename,
            'path' => $path,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        // Return the token as plain text for FilePond to store in the form
        return response($token, 200, ['Content-Type' => 'text/plain']);
    }

    /**
     * Revert/delete an uploaded temporary file if cancelled on the frontend.
     */
    public function revert(Request $request): Response
    {
        // FilePond sends the unique token/id as the request body content
        $token = $request->getContent();

        if (empty($token)) {
            $token = $request->input('token');
        }

        if (empty($token)) {
            $token = $request->input('token');
        }

        if (empty($token)) {
            return response('Token is required.', 400);
        }

        $cleaned = UploadHelper::cleanup($token);

        if ($cleaned) {
            return response('Reverted successfully.', 200);
        }

        return response('Temporary upload not found.', 404);
    }
}
