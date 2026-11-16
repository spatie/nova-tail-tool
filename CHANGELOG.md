# Changelog

All notable changes to `nova-tail-tool` will be documented in this file

## 4.0.0 - 2026-11-16

- Rebuild for Nova 5.11.1+, Laravel 13, and PHP 8.4+. Drop older versions.
- Replace Vue 2, Vue Router registration, Blade navigation, and Mix with Vue 3, Nova Inertia pages, the menu API, and Vite. Ship rebuilt assets using Nova's Vue runtime.
- Use Pest 5 and test against the real Nova 5 package in CI.
- Enforce Nova authentication, Nova authorization, and the registered tool's `canSee` callback on the page and polling endpoint.
- Render log entries as text instead of HTML, retry failed requests, and cancel polling when leaving the page.
- Read `.log` files with PHP instead of `awk`. Handle empty directories, file rotation, and truncation. Keep the latest 500,000 characters in the browser.
- See [UPGRADING](UPGRADING.md) for breaking changes.

## 3.0.1 - 2020-09-09

- add support for Laravel 8

## 3.0.0 - 2020-03-03

- Add Laravel 7.0 & Nova 3.0 support

## 2.1.0 - 2019-09-04

- Add Laravel 6 support

## 2.0.2 - 2019-08-03

- make component title translatable

## 2.0.1 - 2019-08-03

- make navigation title translatable

## 2.0.0

- add support for Laravel 5.8 / Nova 2.0

## 1.0.1 - 2018-08-25

- use `/application-log` url

## 1.0.0 - 2018-08-24

- initial release
