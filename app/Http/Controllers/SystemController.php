<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    /**
     * Clear all application caches.
     */
    public function clear(): JsonResponse
    {
        try {
            Artisan::call('optimize:clear');
            $output = trim(Artisan::output());

            return response()->json([
                'status' => 'success',
                'message' => 'Cache cleared successfully',
                'output' => $output,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to clear cache: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Dynamically recreate the public/storage symbolic link.
     */
    public function storageCreate(): JsonResponse
    {
        $path = public_path('storage');
        $deleted = false;
        $existed = false;

        if (file_exists($path) || is_link($path)) {
            $existed = true;
            try {
                if (is_dir($path) || (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && is_link($path))) {
                    if (is_dir($path) && ! is_link($path)) {
                        $this->deleteDirectory($path);
                    } else {
                        rmdir($path);
                    }
                } else {
                    unlink($path);
                }
                $deleted = true;
            } catch (\Exception $e) {
                try {
                    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                        @unlink($path);
                        @rmdir($path);
                    } else {
                        @unlink($path);
                    }
                    $deleted = true;
                } catch (\Exception $ex) {
                    Log::warning('Failed to delete storage path: '.$ex->getMessage());
                }
            }
        }

        try {
            Artisan::call('storage:link', ['--force' => true]);
            $output = trim(Artisan::output());

            return response()->json([
                'status' => 'success',
                'message' => 'Storage symbolic link created successfully.',
                'existed' => $existed,
                'deleted' => $deleted,
                'output' => $output,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create storage symbolic link: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Start route: fully refresh database, seed data, storage link, and optimize.
     */
    public function start(Request $request): Response
    {
        @set_time_limit(180);

        $passwordHash = env('START_PASSWORD_HASH');
        $password = $request->input('password');
        $error = null;

        if ($passwordHash) {
            if (! $password || ! Hash::check($password, $passwordHash)) {
                if ($password) {
                    $error = 'Incorrect initialization password. Please try again.';
                }

                return response($this->renderPasswordPromptPage($error))->header('Content-Type', 'text/html');
            }
        }

        $startTime = microtime(true);
        $steps = [];
        $hasError = false;

        // Step 1: Database Recreation/Check
        try {
            $database = config('database.connections.mysql.database');
            $charset = config('database.connections.mysql.charset', 'utf8mb4');
            $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');

            config(['database.connections.mysql.database' => null]);
            $query = "CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET $charset COLLATE $collation;";
            DB::statement($query);
            config(['database.connections.mysql.database' => $database]);
            DB::reconnect();

            $steps[] = [
                'name' => 'Database Check/Creation',
                'desc' => "Verified or successfully created the database '$database'.",
                'status' => 'success',
                'output' => "Database '$database' charset=$charset collation=$collation validated successfully.",
            ];
        } catch (\Exception $e) {
            $hasError = true;
            $steps[] = [
                'name' => 'Database Check/Creation',
                'desc' => 'Failed to recreate database.',
                'status' => 'error',
                'output' => $e->getMessage(),
            ];
        }

        // Step 2: Migrate Fresh
        if (! $hasError) {
            try {
                Artisan::call('migrate:fresh', ['--force' => true]);
                $steps[] = [
                    'name' => 'Migrate Fresh',
                    'desc' => 'Dropped all tables and executed fresh migrations.',
                    'status' => 'success',
                    'output' => trim(Artisan::output()),
                ];
            } catch (\Exception $e) {
                $hasError = true;
                $steps[] = [
                    'name' => 'Migrate Fresh',
                    'desc' => 'Failed fresh database migration.',
                    'status' => 'error',
                    'output' => $e->getMessage(),
                ];
            }
        }

        // Step 3: Database Seeding
        if (! $hasError) {
            try {
                Artisan::call('db:seed', ['--force' => true]);
                $steps[] = [
                    'name' => 'Database Seeding',
                    'desc' => 'Populated tables with initial, demo, and CMS settings data.',
                    'status' => 'success',
                    'output' => trim(Artisan::output()),
                ];
            } catch (\Exception $e) {
                $hasError = true;
                $steps[] = [
                    'name' => 'Database Seeding',
                    'desc' => 'Seeding initial database data failed.',
                    'status' => 'error',
                    'output' => $e->getMessage(),
                ];
            }
        }

        // Step 4: Storage Link Setup
        if (! $hasError) {
            try {
                $path = public_path('storage');
                $cleanupDesc = '';
                if (file_exists($path) || is_link($path)) {
                    try {
                        if (is_dir($path) || (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && is_link($path))) {
                            if (is_dir($path) && ! is_link($path)) {
                                $this->deleteDirectory($path);
                            } else {
                                rmdir($path);
                            }
                        } else {
                            unlink($path);
                        }
                    } catch (\Exception $e) {
                        try {
                            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                                @unlink($path);
                                @rmdir($path);
                            } else {
                                @unlink($path);
                            }
                        } catch (\Exception $ex) {
                            Log::warning('Failed to delete storage path during start: '.$ex->getMessage());
                        }
                    }
                    $cleanupDesc = "Cleaned up pre-existing 'public/storage' folder/symlink. ";
                }

                Artisan::call('storage:link', ['--force' => true]);
                $steps[] = [
                    'name' => 'Create Storage Link',
                    'desc' => $cleanupDesc.'Successfully linked backend storage to the public directory.',
                    'status' => 'success',
                    'output' => trim(Artisan::output()),
                ];
            } catch (\Exception $e) {
                $hasError = true;
                $steps[] = [
                    'name' => 'Create Storage Link',
                    'desc' => 'Failed to initialize public storage link.',
                    'status' => 'error',
                    'output' => $e->getMessage(),
                ];
            }
        }

        // Step 5: Optimize Clear
        if (! $hasError) {
            try {
                Artisan::call('optimize:clear');
                $steps[] = [
                    'name' => 'Optimize Clear',
                    'desc' => 'Cleared all compiled files, caches, views, and routing tables.',
                    'status' => 'success',
                    'output' => trim(Artisan::output()),
                ];
            } catch (\Exception $e) {
                $hasError = true;
                $steps[] = [
                    'name' => 'Optimize Clear',
                    'desc' => 'Failed to clear system optimization caches.',
                    'status' => 'error',
                    'output' => $e->getMessage(),
                ];
            }
        }

        // Step 6: Optimize & Cache
        if (! $hasError) {
            try {
                Artisan::call('optimize');
                $steps[] = [
                    'name' => 'Optimize & Cache',
                    'desc' => 'Cached configuration, routing, and bootstrapped files.',
                    'status' => 'success',
                    'output' => trim(Artisan::output()),
                ];
            } catch (\Exception $e) {
                $hasError = true;
                $steps[] = [
                    'name' => 'Optimize & Cache',
                    'desc' => 'Failed to build production caching tables.',
                    'status' => 'error',
                    'output' => $e->getMessage(),
                ];
            }
        }

        $totalTime = number_format(microtime(true) - $startTime, 2);

        $html = $this->renderStatusPage($steps, $totalTime, ! $hasError);

        return response($html)->header('Content-Type', 'text/html');
    }

    /**
     * Recursively delete directory.
     */
    private function deleteDirectory(string $dir): bool
    {
        if (! file_exists($dir)) {
            return true;
        }

        if (! is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (! $this->deleteDirectory($dir.DIRECTORY_SEPARATOR.$item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    /**
     * Render the premium HTML Dashboard for system start/initialization.
     */
    private function renderStatusPage(array $steps, string $totalTime, bool $overallSuccess): string
    {
        $statusColor = $overallSuccess ? '#66BCBA' : '#ef4444';
        $statusBg = $overallSuccess ? 'rgba(102, 188, 186, 0.1)' : 'rgba(239, 68, 68, 0.1)';
        $statusText = $overallSuccess ? 'SYSTEM READY' : 'INITIALIZATION FAILED';
        $statusIcon = $overallSuccess
            ? '<svg class="w-8 h-8 text-teal-500" fill="none" stroke="#66BCBA" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            : '<svg class="w-8 h-8 text-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

        $stepHtml = '';
        foreach ($steps as $index => $step) {
            $num = $index + 1;
            $isSuccess = $step['status'] === 'success';
            $badgeColor = $isSuccess ? 'bg-teal-opaque text-teal-400 border-teal-500/30' : 'bg-red-opaque text-red border-red/30';
            $badgeText = $isSuccess ? 'Success' : 'Error';
            $icon = $isSuccess
                ? '<svg class="w-5 h-5 text-teal-500 mr-2" fill="none" stroke="#66BCBA" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
                : '<svg class="w-5 h-5 text-red mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

            $stepHtml .= "
            <div class=\"step-card bg-slate-800/50 border border-slate-700/50 rounded-xl p-5 hover:border-teal-500/30 transition-all duration-300\">
                <div class=\"flex flex-col md:flex-row md:items-center justify-between gap-4\">
                    <div class=\"flex items-start gap-3\">
                        <div class=\"flex items-center justify-center w-8 h-8 rounded-lg bg-slate-700/50 border border-slate-600/50 text-slate-300 font-bold text-sm\">
                             $num
                        </div>
                        <div>
                            <h3 class=\"text-lg font-semibold text-white flex items-center\">
                                $icon
                                {$step['name']}
                            </h3>
                            <p class=\"text-sm text-slate-400 mt-1\">{$step['desc']}</p>
                        </div>
                    </div>
                    <div>
                        <span class=\"px-3 py-1 text-xs font-semibold rounded-full border $badgeColor\">
                            $badgeText
                        </span>
                    </div>
                </div>
                
                <details class=\"mt-4 group\">
                    <summary class=\"text-xs text-slate-500 hover:text-teal-500 cursor-pointer select-none outline-none flex items-center gap-1 transition-colors\">
                        <svg class=\"w-3 h-3 transform group-open:rotate-90 transition-transform\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2.5\" d=\"M9 5l7 7-7 7\"></path></svg>
                        View Output Logs
                    </summary>
                    <pre class=\"mt-3 p-4 bg-slate-900 border border-slate-700/50 rounded-lg text-slate-300 font-mono text-xs overflow-x-auto whitespace-pre-wrap leading-relaxed max-h-60\">".htmlspecialchars($step['output'])."</pre>
                </details>
            </div>";
        }

        return "
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>System Diagnostics & Initialization | Lumos</title>
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap\" rel=\"stylesheet\">
    <script src=\"https://cdn.tailwindcss.com\"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            500: '#66BCBA',
                            400: '#75cac8'
                        },
                        slate: {
                            800: '#1e293b',
                            900: '#0f172a'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #05070f;
        }
        h1, h2, h3, .font-display {
            font-family: 'Outfit', sans-serif;
        }
        .text-teal { color: #66BCBA; }
        .bg-teal-opaque { background-color: rgba(102, 188, 186, 0.15); }
        .bg-red-opaque { background-color: rgba(239, 110, 110, 0.15); }
        .step-card:hover {
            box-shadow: 0 4px 20px -2px rgba(102, 188, 186, 0.08);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class=\"text-slate-100 min-h-screen py-12 px-4 md:px-8\">
    <div class=\"max-w-4xl mx-auto\">
        <header class=\"text-center mb-10\">
            <div class=\"inline-flex items-center gap-2 px-3 py-1 rounded-full border border-teal-500/30 bg-teal-500/5 mb-4\">
                <span class=\"w-2 h-2 rounded-full bg-teal-500 animate-pulse\"></span>
                <span class=\"text-xs tracking-wider uppercase font-semibold text-teal-500\">System Utilities</span>
            </div>
            <h1 class=\"text-3xl md:text-5xl font-bold tracking-tight text-white mb-2\">
                Lumos <span class=\"text-teal-500\">CMS</span>
            </h1>
            <p class=\"text-slate-400 text-sm md:text-base\">System Diagnostic & Data Seeding Dashboard</p>
        </header>

        <div class=\"bg-slate-800/40 border border-slate-700/50 rounded-2xl p-6 md:p-8 mb-8 backdrop-blur-sm\">
            <div class=\"flex flex-col md:flex-row items-center justify-between gap-6\">
                <div class=\"flex items-center gap-4\">
                    <div class=\"p-3 rounded-2xl\" style=\"background-color: $statusBg;\">
                        $statusIcon
                    </div>
                    <div>
                        <div class=\"text-xs font-semibold uppercase tracking-wider text-slate-500\">Deployment Status</div>
                        <h2 class=\"text-xl md:text-2xl font-bold mt-0.5\" style=\"color: $statusColor;\">$statusText</h2>
                    </div>
                </div>
                <div class=\"flex gap-6 border-t md:border-t-0 md:border-l border-slate-700/80 pt-4 md:pt-0 md:pl-8 w-full md:w-auto justify-between md:justify-start\">
                    <div>
                        <div class=\"text-xs font-medium text-slate-500 uppercase\">Elapsed Time</div>
                        <div class=\"text-lg font-bold text-white mt-1\">{$totalTime}s</div>
                    </div>
                    <div class=\"md:ml-8\">
                        <div class=\"text-xs font-medium text-slate-500 uppercase\">Environment</div>
                        <div class=\"text-lg font-bold text-teal-500 mt-1 uppercase\">Local/Debug</div>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"space-y-4\">
            <div class=\"flex items-center justify-between px-1\">
                <h3 class=\"text-lg font-bold text-white\">Execution Steps</h3>
                <span class=\"text-xs text-slate-500 font-medium\">Sequential Order</span>
            </div>
            
            $stepHtml
        </div>

        <footer class=\"mt-12 text-center flex flex-col md:flex-row items-center justify-between gap-4 border-t border-slate-800 pt-8\">
            <p class=\"text-xs text-slate-500\">
                Run `/clear` to manually reset configuration tables. Authorized under Debug Mode only.
            </p>
            <div class=\"flex gap-3\">
                <a href=\"/\" class=\"px-4 py-2 text-xs font-semibold text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-lg transition-all\">
                    Back to Home
                </a>
                <a href=\"/admin/dashboard\" class=\"px-4 py-2 text-xs font-semibold text-slate-900 bg-teal-500 hover:bg-teal-500/90 rounded-lg transition-all\">
                    Go to Dashboard
                </a>
            </div>
        </footer>
    </div>
</body>
</html>
";
    }

    /**
     * Render the password prompt page.
     */
    private function renderPasswordPromptPage(?string $error): string
    {
        $errorHtml = $error ? "
        <div class=\"bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6 flex items-start gap-3\">
            <svg class=\"w-5 h-5 text-red-500 mt-0.5 flex-shrink-0\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z\"></path></svg>
            <p class=\"text-sm text-red-400 font-medium\">$error</p>
        </div>" : '';

        return "
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Authorize System Initialization | Lumos</title>
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap\" rel=\"stylesheet\">
    <script src=\"https://cdn.tailwindcss.com\"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            500: '#66BCBA'
                        },
                        slate: {
                            800: '#1e293b',
                            900: '#0f172a'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #05070f;
        }
        h1, h2, h3, .font-display {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class=\"text-slate-100 min-h-screen flex items-center justify-center p-4\">
    <div class=\"max-w-md w-full bg-slate-800/40 border border-slate-700/50 rounded-3xl p-8 backdrop-blur-md shadow-2xl relative overflow-hidden\">
        <div class=\"absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-teal-500 to-transparent\"></div>
        
        <header class=\"text-center mb-8\">
            <div class=\"inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-teal-500/10 border border-teal-500/30 mb-4\">
                <svg class=\"w-8 h-8 text-teal-500\" fill=\"none\" stroke=\"#66BCBA\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z\"></path></svg>
            </div>
            <h1 class=\"text-2xl md:text-3xl font-bold text-white\">System Authorization</h1>
            <p class=\"text-slate-400 text-xs md:text-sm mt-2\">Authorization is required to drop and seed dynamic databases.</p>
        </header>

        $errorHtml

        <form method=\"GET\" action=\"/start\" class=\"space-y-6\">
            <div>
                <label for=\"password\" class=\"block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2\">Security Password</label>
                <div class=\"relative\">
                    <input type=\"password\" id=\"password\" name=\"password\" required autocomplete=\"current-password\" placeholder=\"••••••••\" 
                           class=\"w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700/80 text-white placeholder-slate-600 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 outline-none transition-all text-sm font-medium\">
                </div>
            </div>

            <button type=\"submit\" class=\"w-full py-3 px-4 bg-teal-500 hover:bg-teal-500/90 text-white font-bold rounded-xl shadow-lg shadow-teal-500/10 hover:shadow-teal-500/20 transition-all duration-300 flex items-center justify-center gap-2 text-sm\">
                <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M13 10V3L4 14h7v7l9-11h-7z\"></path></svg>
                Confirm & Reinitialize
            </button>
        </form>

        <footer class=\"mt-8 text-center\">
            <a href=\"/\" class=\"text-xs text-slate-500 hover:text-slate-300 transition-colors\">← Cancel & Return to Site</a>
        </footer>
    </div>
</body>
</html>
";
    }
}
