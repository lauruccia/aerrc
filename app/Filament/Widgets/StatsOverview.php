<?php

namespace App\Filament\Widgets;

use App\Models\Destination;
use App\Models\NewsletterSubscriber;
use App\Models\Partner;
use App\Models\TourismArticle as Article;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $publishedArticles = Article::where('is_published', true)->count();
        $draftArticles     = Article::where('is_published', false)->count();
        $breakingNews      = Article::where('is_breaking', true)->where('is_published', true)->count();

        $subscribers       = NewsletterSubscriber::where('is_active', true)->count();
        $newSubscribers    = NewsletterSubscriber::where('is_active', true)
                                ->where('created_at', '>=', now()->subDays(30))
                                ->count();

        $activeDestinations = Destination::where('is_active', true)->count();
        $activePartners     = Partner::where('is_active', true)->count();
        $goldPartners       = Partner::where('tier', 'gold')->where('is_active', true)->count();

        return [
            Stat::make('Articoli pubblicati', $publishedArticles)
                ->description("{$draftArticles} bozze" . ($breakingNews > 0 ? " · {$breakingNews} breaking" : ''))
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->url(route('filament.admin.resources.articles.index')),

            Stat::make('Iscritti newsletter', $subscribers)
                ->description("+{$newSubscribers} negli ultimi 30 giorni")
                ->icon('heroicon-o-envelope')
                ->color('info')
                ->url(route('filament.admin.resources.newsletter-subscribers.index')),

            Stat::make('Destinazioni attive', $activeDestinations)
                ->description('Rotte da Reggio Calabria')
                ->icon('heroicon-o-globe-alt')
                ->color('warning')
                ->url(route('filament.admin.resources.destinations.index')),

            Stat::make('Partner attivi', $activePartners)
                ->description("{$goldPartners} Gold partner")
                ->icon('heroicon-o-building-office-2')
                ->color('primary')
                ->url(route('filament.admin.resources.partners.index')),
        ];
    }
}
