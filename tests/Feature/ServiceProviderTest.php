<?php

declare(strict_types=1);

use Accelade\Infolist\Components\TextEntry;
use Accelade\Infolist\Infolist;

describe('Service Provider Registration', function () {
    it('registers the infolist singleton', function () {
        expect(app()->bound('infolist'))->toBeTrue();
        expect(app('infolist'))->toBeInstanceOf(Infolist::class);
    });

    it('returns same instance for infolist singleton', function () {
        $instance1 = app('infolist');
        $instance2 = app('infolist');

        expect($instance1)->toBe($instance2);
    });

    it('loads config from infolist.php', function () {
        expect(config('infolist'))->toBeArray();
        expect(config('infolist.placeholder'))->toBe('—');
    });
});

describe('View Loading', function () {
    it('loads views from infolist namespace', function () {
        $hints = app('view')->getFinder()->getHints();

        expect($hints)->toHaveKey('infolist');
    });

    it('can resolve infolist component views', function () {
        $factory = app('view');

        expect($factory->exists('infolist::components.infolist'))->toBeTrue();
    });
});

describe('Infolist Rendering', function () {
    it('can render infolist view', function () {
        $infolist = Infolist::make()
            ->record(['name' => 'John'])
            ->schema([
                TextEntry::make('name'),
            ]);

        $view = $infolist->render();

        expect($view)->toBeInstanceOf(\Illuminate\Contracts\View\View::class);
    });
});
