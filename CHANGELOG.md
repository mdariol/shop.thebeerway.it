# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

Log of unreleased changes.

### Changed

- `*_liter` and `*_unit` prices are now calculated.
- Deploying to `stage` does not require a tag.

### Fixes

- Prices are calculated when `PriceEdit.vue` is mounted.

## v0.2.0

Released on **2019/06/24**.

### Added

- Use [spatie/laravel-backup](https://github.com/spatie/laravel-backup) to backup the application.
- Adds `fatture:sync` command.
- Adds `Taste` model.

### Changed

- Adds `colors` and `tastes` columns to `fatture:read beers` command.
- `App\Price` now can be imported via `fatture:import beers` command.
- `App\Taste` now can be imported via `fatture:import beers|tastes` commands. 
- Functions `parse*()` of `FattureInCloud` service now returns `Model` or `Collection` instances.

## v0.1.0

Released on **2019/06/18**.

### Added

- Use [Deployer](https://deployer.org/) to deploy the application.
