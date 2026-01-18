<?php

declare(strict_types=1);

namespace Accelade\Infolist;

use Accelade\Accelade;
use Accelade\Docs\DocsRegistry;
use Illuminate\Support\ServiceProvider;

class InfolistServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/infolist.php', 'infolist');

        $this->app->singleton('infolist', function () {
            return new Infolist;
        });
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'infolist');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/infolist.php' => config_path('infolist.php'),
            ], 'infolist-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/infolist'),
            ], 'infolist-views');

            $this->publishes([
                __DIR__.'/../dist' => public_path('vendor/infolist'),
            ], 'infolist-assets');
        }

        // Register infolist scripts with Accelade
        if ($this->app->bound('accelade')) {
            $this->registerScripts();
        }

        // Register documentation sections
        if ($this->app->bound('accelade.docs')) {
            $this->registerDocs();
        }
    }

    /**
     * Register infolist JavaScript and CSS with Accelade.
     */
    protected function registerScripts(): void
    {
        /** @var Accelade $accelade */
        $accelade = $this->app->make('accelade');

        // Register CSS styles
        $accelade->registerStyle('infolist', function () {
            $css = '';

            // First try dist CSS
            $distCssPath = __DIR__.'/../dist/accelade-infolist.css';
            if (file_exists($distCssPath)) {
                $css .= file_get_contents($distCssPath);
            }

            // Also include custom infolist.css if exists
            $customCssPath = __DIR__.'/../resources/css/infolist.css';
            if (file_exists($customCssPath)) {
                $css .= "\n".file_get_contents($customCssPath);
            }

            if ($css) {
                return "<style data-infolist-styles>\n{$css}\n</style>";
            }

            return '';
        });

        // Register JavaScript
        $accelade->registerScript('infolist', function () {
            // First try the built dist file
            $distPath = __DIR__.'/../dist/infolist.iife.js';
            if (file_exists($distPath)) {
                $js = file_get_contents($distPath);

                return "<script data-infolist-scripts>\n{$js}\n</script>";
            }

            // Fallback to minimal inline initialization
            return $this->getInlineInfolistScripts();
        });
    }

    /**
     * Get inline infolist initialization scripts.
     */
    protected function getInlineInfolistScripts(): string
    {
        return <<<'HTML'
<script data-infolist-scripts>
(function() {
    'use strict';

    // Infolist initialization
    function initInfolist() {
        initCopyable();
    }

    // Copyable functionality
    function initCopyable() {
        document.querySelectorAll('[data-copyable]').forEach(function(el) {
            if (el.dataset.copyableInitialized) return;
            el.dataset.copyableInitialized = 'true';

            el.addEventListener('click', function() {
                var text = el.dataset.copyableValue || el.textContent.trim();
                navigator.clipboard.writeText(text).then(function() {
                    // Show success feedback
                    var originalText = el.innerHTML;
                    el.innerHTML = '<span class="text-green-600 dark:text-green-400">Copied!</span>';
                    setTimeout(function() {
                        el.innerHTML = originalText;
                    }, 1500);
                });
            });
        });
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initInfolist);
    } else {
        initInfolist();
    }

    // Re-initialize on Accelade navigation events
    document.addEventListener('accelade:navigated', initInfolist);
    document.addEventListener('accelade:updated', initInfolist);

    // Export for manual use
    window.AcceladeInfolist = {
        init: initInfolist,
        initCopyable: initCopyable
    };
})();
</script>
HTML;
    }

    /**
     * Register documentation sections with the Accelade docs portal.
     */
    protected function registerDocs(): void
    {
        /** @var DocsRegistry $docs */
        $docs = $this->app->make('accelade.docs');

        // Register package docs path
        $docs->registerPackage('infolist', __DIR__.'/../docs');

        // Register navigation group
        $docs->registerGroup('infolist', 'Infolist', '📋', 40);

        // Register sections
        $docs->section('infolist-getting-started')
            ->label('Getting Started')
            ->icon('🚀')
            ->markdown('getting-started.md')
            ->package('infolist')
            ->description('Introduction to Accelade Infolist')
            ->keywords(['infolist', 'introduction', 'installation', 'setup'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-text-entry')
            ->label('Text Entry')
            ->icon('📝')
            ->markdown('text-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display text with formatting options')
            ->keywords(['text', 'entry', 'display', 'format', 'badge', 'copy'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-icon-entry')
            ->label('Icon Entry')
            ->icon('🎯')
            ->markdown('icon-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display icons with boolean mode')
            ->keywords(['icon', 'entry', 'boolean', 'status'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-image-entry')
            ->label('Image Entry')
            ->icon('🖼️')
            ->markdown('image-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display single or multiple images')
            ->keywords(['image', 'entry', 'avatar', 'photo', 'gallery'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-color-entry')
            ->label('Color Entry')
            ->icon('🎨')
            ->markdown('color-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display color swatches')
            ->keywords(['color', 'entry', 'swatch', 'hex', 'rgb'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-key-value-entry')
            ->label('Key Value Entry')
            ->icon('🔑')
            ->markdown('key-value-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display key-value pairs')
            ->keywords(['key', 'value', 'entry', 'table', 'metadata'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-repeatable-entry')
            ->label('Repeatable Entry')
            ->icon('🔄')
            ->markdown('repeatable-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display repeated data with nested schema')
            ->keywords(['repeatable', 'entry', 'nested', 'list', 'grid'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-badge-entry')
            ->label('Badge Entry')
            ->icon('🏷️')
            ->markdown('badge-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display values as styled badges with color mapping')
            ->keywords(['badge', 'entry', 'status', 'tag', 'label', 'color'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-code-entry')
            ->label('Code Entry')
            ->icon('💻')
            ->markdown('code-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display code snippets with syntax highlighting')
            ->keywords(['code', 'entry', 'syntax', 'highlight', 'snippet', 'json', 'php'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-qr-code-entry')
            ->label('QR Code Entry')
            ->icon('📱')
            ->markdown('qr-code-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display QR codes and barcodes')
            ->keywords(['qr', 'code', 'barcode', 'entry', 'scan'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-rating-entry')
            ->label('Rating Entry')
            ->icon('⭐')
            ->markdown('rating-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display ratings with stars or hearts')
            ->keywords(['rating', 'star', 'heart', 'score', 'entry'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-separator-entry')
            ->label('Separator Entry')
            ->icon('➖')
            ->markdown('separator-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display horizontal or vertical dividers')
            ->keywords(['separator', 'divider', 'hr', 'line', 'entry'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-html-entry')
            ->label('HTML Entry')
            ->icon('📄')
            ->markdown('html-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display HTML or Markdown content')
            ->keywords(['html', 'markdown', 'content', 'prose', 'entry'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-markdown-entry')
            ->label('Markdown Entry')
            ->icon('📝')
            ->markdown('markdown-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display markdown content with docs-style prose')
            ->keywords(['markdown', 'prose', 'content', 'gfm', 'github', 'entry'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-progress-entry')
            ->label('Progress Entry')
            ->icon('📊')
            ->markdown('progress-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display progress bars')
            ->keywords(['progress', 'bar', 'percentage', 'completion', 'entry'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-secret-entry')
            ->label('Secret Entry')
            ->icon('🔒')
            ->markdown('secret-entry.md')
            ->package('infolist')
            ->demo()
            ->description('Display masked sensitive data')
            ->keywords(['secret', 'password', 'masked', 'hidden', 'entry'])
            ->inGroup('infolist')
            ->register();

        $docs->section('infolist-api-reference')
            ->label('API Reference')
            ->icon('📚')
            ->markdown('api-reference.md')
            ->package('infolist')
            ->description('Complete API documentation')
            ->keywords(['api', 'reference', 'methods', 'options'])
            ->inGroup('infolist')
            ->register();
    }
}
