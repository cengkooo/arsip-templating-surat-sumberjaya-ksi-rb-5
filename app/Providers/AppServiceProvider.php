<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Livewire\Features\SupportFileUploads\FileUploadController;
use Livewire\Features\SupportFileUploads\FilePreviewController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * When the app is served from a subdirectory (e.g. http://localhost/foo/public),
         * Livewire's default `/livewire/*` endpoints point to the domain root.
         * Here we prefix Livewire's script and update endpoints with the path part of APP_URL
         * so the assets and XHR requests hit this application instead of the webroot.
         */
        $basePath = parse_url(config('app.url'), PHP_URL_PATH) ?? '';
        $basePath = rtrim($basePath, '/');

        // If no base path (app served from domain root), keep defaults.
        if ($basePath !== '') {
            Livewire::setScriptRoute(
                fn ($handle) => Route::get("{$basePath}/livewire/livewire.js", $handle)
            );

            Livewire::setUpdateRoute(
                fn ($handle) => Route::post("{$basePath}/livewire/update", $handle)->middleware('web')
            );

            /**
             * Prefix Livewire upload & preview endpoints with the base path so signed URLs generated
             * for a subdirectory install stay valid.
             * Use closures to avoid "Invalid route action" on Laravel route parsing.
             */
            Route::middleware('web')->group(function () use ($basePath) {
                Route::post("{$basePath}/livewire/upload-file", function () {
                    return app(FileUploadController::class)->handle();
                })->name('livewire.upload-file');

                Route::get("{$basePath}/livewire/preview-file/{filename}", function ($filename) {
                    return app(FilePreviewController::class)->handle($filename);
                })->name('livewire.preview-file');
            });
        }
    }
}
