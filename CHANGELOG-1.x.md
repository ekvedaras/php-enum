# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.1] - 2020-09-08
### Updated
- Allow `illuminate/support` `v8`

## [1.2.0] - 2020-09-07
### Added
- `voku/arrayy` `Arrayy` implementation

### Updated
- Rename `ArrayAccessibleStorage` to `GenericArrayAccessibleStorage`
- Extract common methods to `GenericArrayAccessibleObjectStorage`

## [1.1.1] - 2020-09-02
### Fixed
- There was an issue when calling `Enum::option1()` and then calling `Enum::from('option2')`, `option2` was not registered.

### Updated
- Use `static::clas` instead of `get_called_class()`
- Use `static::$cache` instead of `self::$cache`

## [1.1.0] - 2020-08-31
### Added
- `keyString` static method to fetch as string, glued by comma by default

## [1.0.1] - 2020-08-30
### Fixed
- Make `BaseEnum::$cache` protected as it was left public.

## [1.0.0] - 2020-08-30
### Added
- Array and illuminate collection implementations

[Unreleased]:  https://github.com/ekvedaras/php-enum/compare/v1.2.1...HEAD
[1.2.1]:  https://github.com/ekvedaras/php-enum/compare/v1.2.0...v1.2.1
[1.2.0]:  https://github.com/ekvedaras/php-enum/compare/v1.1.1...v1.2.0
[1.1.1]:  https://github.com/ekvedaras/php-enum/compare/v1.1.0...v1.1.1
[1.1.0]:  https://github.com/ekvedaras/php-enum/compare/v1.0.1...v1.1.0
[1.0.1]:  https://github.com/ekvedaras/php-enum/compare/v1.0.0...v1.0.1
[1.0.0]:  https://github.com/ekvedaras/php-enum/releases/tag/v1.0.0
