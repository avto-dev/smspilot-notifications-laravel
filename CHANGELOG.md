# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## Unreleased

### Added

- Laravel `12.x` support
- Using `docker` with `compose` plugin instead of `docker-compose` for test environment

### Changed

- Minimal require PHP version now is `8.2`
- Version of `composer` in docker container updated up to `2.8.9`
- Updated dev dependencies

## v2.6.0

### Added

- Laravel `11.x` support

### Changed

- Minimal Laravel version now is `10.0`
- Version of `composer` in docker container updated up to `2.7.6`
- Updated dev dependencies

## v2.5.0

### Changed

- Composer `2.x` is supported now
- Minimal Laravel version now is `9.0`
- Minimal require PHP version now is `8.0`

### Removed

- Ability to create a message through the static method `::create()`

## v2.4.0

### Added

- Support PHP `8.x`

### Changed

- Minimal PHP version now is `7.3`
- Composer `2.x` is supported now

## v2.3.0

### Changed

- Laravel `8.x` is supported now
- Guzzle 7 (`guzzlehttp/guzzle`) is supported now
- Minimal Laravel version now is `6.0` (Laravel `5.5` LTS got last security update August 30th, 2020)
- CI completely moved from "Travis CI" to "Github Actions" _(travis builds disabled)_
- Minimal required PHP version now is `7.2`

## v2.2.0

### Changed

- Maximal `illuminate/*` packages version now is `7.*`

## v2.1.0

### Changed

- Maximal `illuminate/*` packages version now is `6.*`

### Added

- GitHub actions for a tests running

## v2.0.0

### Changed

- Minimal `PHP` version now is `^7.1.3`
- Maximal `Laravel` version now is `5.8.x`
- Dependency `laravel/framework` changed to `illuminate/*`
- Composer scripts

### Added

- Docker-based environment for development
- Type-hinting
- Interface `SmsPilotExceptionInterface`
- Project `Makefile`

### Removed

- PHPUnit bootstrapper class

## v1.1.0

### Changed

- Maximal PHP version now is undefined
- Maximal Laravel version now is `5.7.*`
- CI changed to [Travis CI][travis]
- [CodeCov][codecov] integrated
- Issue templates updated

[travis]:https://travis-ci.org/
[codecov]:https://codecov.io/

## v1.0.3

### Changed

- CI config updated
- Required minimal PHPUnit version now `5.7.10`
- Disabled HTML coverage report (CI errors)
- Unimportant PHPDoc blocks removed
- Code a little bit refactored

[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
