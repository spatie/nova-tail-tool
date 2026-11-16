# Upgrading

## From 3.x to 4.x

Version 4 is a rebuild for Nova 5. It requires PHP 8.4+, Laravel 13, and Nova 5.11.1+. Tests use Pest 5. Laravel 12 is dropped because its Testbench requires Symfony Process 7, while Pest 5 requires Symfony Process 8.

1. Upgrade your application to the required PHP, Laravel, and Nova versions. Ensure your Nova license can download Nova 5.11.1.
2. Run `composer require spatie/nova-tail-tool:^4.0 --with-all-dependencies`.
3. Keep `new \Spatie\TailTool\TailTool` in your `NovaServiceProvider::tools()` method. Review its `canSee` callback: both the page and polling endpoint now authorize against this registered instance.
4. Run `php artisan optimize:clear`, then rebuild your application's route cache if you use it.

The menu label and `/nova/application-log` URL remain the same. Custom Nova paths are supported. No assets need to be published or compiled in the consuming application.

The tool now uses Nova's Inertia pages and menu API instead of Vue Router and Blade navigation. If you customized `renderNavigation()`, move that customization to `menu()`. JavaScript extensions built against Vue 2 must be updated for Vue 3. To build package assets, use `npm ci && npm run build` instead of Mix or Yarn commands.

Only `.log` files inside `storage/logs` are considered. The tool still starts at the end of the latest file rather than loading historical entries. It follows rotation and truncation, renders log content as plain text, and limits the browser buffer to 500,000 characters. PHP reads files directly; `awk` is no longer required. File contents are returned unchanged, without adding a trailing newline.

The internal polling response now includes a `file` identifier. Custom clients should send that identifier back with `afterLineNumber` so the server can detect rotation.
