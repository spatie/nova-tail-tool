<?php

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\File;
use Laravel\Nova\Http\Middleware\HandleInertiaRequests;
use Laravel\Nova\Nova;
use Spatie\TailTool\TailTool;

beforeEach(function () {
    $this->actingAs((new User)->forceFill(['id' => 1, 'name' => 'Log reader', 'email' => 'reader@example.com']));
    File::ensureDirectoryExists(storage_path('logs'));
    File::cleanDirectory(storage_path('logs'));
    file_put_contents(storage_path('logs/laravel.log'), "one\ntwo\nthree\n");
});

it('starts listening at the end and returns only newly appended lines', function () {
    $cursor = $this->postJson('nova-vendor/spatie/tail-tool')
        ->assertOk()
        ->assertJsonPath('text', '')
        ->assertJsonPath('lastRetrievedLineNumber', 3)
        ->json();

    file_put_contents(storage_path('logs/laravel.log'), "four\nfive\n", FILE_APPEND);

    $this->postJson('nova-vendor/spatie/tail-tool', [
        'afterLineNumber' => $cursor['lastRetrievedLineNumber'],
        'file' => $cursor['file'],
    ])->assertOk()->assertJsonPath('text', "four\nfive\n")
        ->assertJsonPath('lastRetrievedLineNumber', 5);
});

it('can start from a specific line', function () {
    $this->postJson('nova-vendor/spatie/tail-tool', ['afterLineNumber' => 1])
        ->assertOk()->assertJsonPath('text', "two\nthree\n");
});

it('handles an empty or missing log directory', function () {
    File::deleteDirectory(storage_path('logs'));

    $this->postJson('nova-vendor/spatie/tail-tool')->assertOk()->assertJsonPath('text', '')
        ->assertJsonPath('lastRetrievedLineNumber', 0);
});

it('ignores files that are not logs', function () {
    file_put_contents(storage_path('logs/secret.txt'), 'not a log');
    touch(storage_path('logs/secret.txt'), time() + 10);

    $this->postJson('nova-vendor/spatie/tail-tool', ['afterLineNumber' => 0])
        ->assertOk()->assertJsonPath('text', "one\ntwo\nthree\n");
});

it('continues after log rotation or truncation', function (bool $rotate) {
    $cursor = $this->postJson('nova-vendor/spatie/tail-tool')->assertOk()->json();

    if ($rotate) {
        rename(storage_path('logs/laravel.log'), storage_path('logs/laravel.log.1'));
    }

    file_put_contents(storage_path('logs/laravel.log'), "new log\n");

    $this->postJson('nova-vendor/spatie/tail-tool', [
        'afterLineNumber' => $cursor['lastRetrievedLineNumber'],
        'file' => $cursor['file'],
    ])->assertOk()->assertJsonPath('text', "new log\n")
        ->assertJsonPath('lastRetrievedLineNumber', 1);
})->with([true, false]);

it('rejects invalid cursors', function (mixed $cursor) {
    $this->postJson('nova-vendor/spatie/tail-tool', ['afterLineNumber' => $cursor])
        ->assertUnprocessable()->assertJsonValidationErrors('afterLineNumber');
})->with([-1, 1.5, 'not a number']);

it('requires authentication for the page and log endpoint', function () {
    auth()->forgetGuards();

    $this->getJson('nova/application-log')->assertUnauthorized();
    $this->postJson('nova-vendor/spatie/tail-tool')->assertUnauthorized();
});

it('honors the registered tools canSee callback on both routes', function () {
    Nova::$tools = [(new TailTool)->canSee(fn () => false)];

    $this->getJson('nova/application-log')->assertForbidden();
    $this->postJson('nova-vendor/spatie/tail-tool')->assertForbidden();
});

it('denies users who cannot access Nova', function () {
    Nova::auth(fn () => false);

    $this->getJson('nova/application-log')->assertForbidden();
    $this->postJson('nova-vendor/spatie/tail-tool')->assertForbidden();
});

it('does not expose logs when the tool is not registered', function () {
    Nova::$tools = [];

    $this->getJson('nova/application-log')->assertNotFound();
    $this->postJson('nova-vendor/spatie/tail-tool')->assertNotFound();
});

it('registers an Inertia page and a Nova menu item', function () {
    $this->get('nova/application-log', [
        'X-Inertia' => 'true',
        'X-Inertia-Version' => app(HandleInertiaRequests::class)->version(request()),
    ])->assertOk()->assertJsonPath('component', 'TailTool');

    expect((new TailTool)->menu(request())->jsonSerialize()['path'])->toBe('/nova/application-log');
});
