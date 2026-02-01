<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    config(['database.default' => 'pgsql']);
    config(['database.connections.pgsql' => [
        'driver' => 'pgsql',
        'host' => 'pgsql',
        'port' => 5432,
        'database' => 'testing',
        'username' => 'pest',
        'password' => 'password'
    ]]);

    DB::purge('pgsql'); // Clear the resolver cache
    DB::reconnect('pgsql');

    Artisan::call('migrate');
});

it('can query options as json', function() {

    $query = \LaraZeus\Bolt\Models\Field::whereJsonContains('options->dataSource', 'test');

    \LaraZeus\Bolt\Models\Field::whereJsonContains('options->dataSource', 'test')->get();

    // NB: If we got here then no query exception was thrown
    expect(true)->toBe(true);

});
