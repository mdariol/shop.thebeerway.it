# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

Log of unreleased changes.

### Changed

- Adds `isHoreca()` method on `User` model.
- Removes `is_horeca` field on `User` model.
- Adds `legal_person` filter on `BillingProfile` model. 

### Fixed

- Fixes Maps API key retrieving.
- Unlocks `assignPublicanRole()` and `removePublicanRole()` methods.

## v1.0.0

Released on **2019/10/31**.

### Added

- Adds `ShippingAddress` model.
- Adds `BillingProfile` model.
- Use [winzou/state-machine](https://github.com/winzou/state-machine) library to manage states.
- Use [intervention/image](https://github.com/Intervention/image) library to resize images.
- Adds `profile_image` to users.
- Use [vue-i18n](https://github.com/kazupon/vue-i18n) library to translate Vue components.

### Changed

- Logs user searches.

### Fixed

- Fixes backup strategy.

## v0.3.0

Released on **2019/07/19**.

### Added

- Requires email verification.
- Sends `Approval` email when Ho.Re.Ca. user is verified.

### Changed

- Temporarily remove Facebook and Google login.

### Fixed

- Fixes `Taste` import in `TasteController`.
- Fixes `color_id` and `taste_id` values not saved on `Beer` `create` and `update`.
- Fixes wrong management of `is_horeca` value in `RegisterController@create` method. 

## v0.2.3

Released on **2019/07/10**.

### Fixed

- Fixes `Style` create form.

## v0.2.2

Released on **2019/07/09**.

### Changed

- Changes `facebook_id` and `google_id` column type to `string`.

### Fixed

- Uses `ILIKE` instead of `LIKE` in `BeerFilters`.

## v0.2.1

Released on **2019/07/09**.

### Changed

- `*_liter` and `*_unit` prices are now calculated fields.
- Deploying to `stage` does not require a tag.
- Prices are stored as `decimal` instead of `integer`.
- Use Postgresql as default database.

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
