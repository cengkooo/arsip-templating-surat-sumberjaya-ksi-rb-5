<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('DIARSIP')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\SuratPerBulanChart::class,
                \App\Filament\Widgets\TemplateUsageChart::class,
                \App\Filament\Widgets\RecentSuratTable::class,
                \App\Filament\Widgets\ArsipSuratDashboardTable::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                'panels::head.start',
                /**
                 * Guard the sidebar store so Alpine errors don't break the panel
                 * when assets are cached or loaded twice.
                 */
                static fn (): string => <<<'HTML'
                    <script>
                        (() => {
                            if (window.__filamentSidebarStorePatched) return;

                            const ensureSidebarStore = () => {
                                const Alpine = window.Alpine;
                                if (!Alpine || typeof Alpine.store !== 'function') {
                                    return false;
                                }

                                const persist = Alpine.$persist
                                    ? (value, key) => Alpine.$persist(value).as(key)
                                    : (value) => value;

                                if (!Alpine.store('sidebar')) {
                                    Alpine.store('sidebar', {
                                        isOpen: persist(true, 'isOpen'),
                                        collapsedGroups: persist([], 'collapsedGroups'),
                                        groupIsCollapsed(label) {
                                            return Array.isArray(this.collapsedGroups)
                                                ? this.collapsedGroups.includes(label)
                                                : false;
                                        },
                                        toggleCollapsedGroup(label) {
                                            if (!Array.isArray(this.collapsedGroups)) {
                                                this.collapsedGroups = [];
                                            }
                                            this.collapsedGroups = this.collapsedGroups.includes(label)
                                                ? this.collapsedGroups.filter((item) => item !== label)
                                                : this.collapsedGroups.concat(label);
                                        },
                                        close() { this.isOpen = false; },
                                        open() { this.isOpen = true; },
                                    });
                                }

                                window.__filamentSidebarStorePatched = true;
                                return true;
                            };

                            const kickOff = () => {
                                if (ensureSidebarStore()) return;
                                const watcher = setInterval(() => {
                                    if (ensureSidebarStore()) {
                                        clearInterval(watcher);
                                    }
                                }, 30);
                                setTimeout(() => clearInterval(watcher), 2000);
                            };

                            if (document.readyState === 'complete') {
                                kickOff();
                            } else {
                                window.addEventListener('load', kickOff, { once: true });
                            }

                            document.addEventListener('alpine:init', ensureSidebarStore, { once: true });
                        })();
                    </script>
                HTML,
            );
    }
}
