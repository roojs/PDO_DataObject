# Changelog

All notable changes to PDO_DataObject are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project follows [Semantic Versioning](https://semver.org/spec/v2.0.0.html)
for git tags (`v0.1.0`, etc.).

GitHub release notes are taken from this file by `.github/workflows/release.yml`.
Humans tag a release with `scripts/release.sh` after stamping `[Unreleased]`
as `## [X.Y.Z] - YYYY-MM-DD` and running `scripts/release/package.sh`
(that writes `package2.xml`, `composer.json`, and rebuilds `docs/` from this
file and the PHP sources).

## [Unreleased]

## [0.1.0] - 2026-08-28

### Changed

- Require PHP 8.4+; PHP 5 / 7 / 8.0–8.3 are no longer supported
- Use `Pdo\<Driver>::ATTR_*` constants instead of deprecated `PDO::MYSQL_ATTR_*`
- DSN fragment options resolve constants on the driver subclass for the DSN scheme

### Fixed

- Declare `PDO_DataObject_Introspection::$last_query` instead of a dynamic property
- Declare `PDO_Dummy` connection fields used by the test harness

## [0.0.5] - 2026-08-27

### Fixed

- `escape()` no longer over-strips wrapper quotes from `PDO::quote()` when the
  value itself ends with a quote

## [0.0.4] - 2019-07-15

### Changed

- Remove `final` from `table()` to improve backward compatibility

## [0.0.3] - 2019-07-12

### Changed

- Remove `final` from `update()` / `insert()` / `delete()` to improve backward
  compatibility

## [0.0.2] - 2018-01-14

### Fixed

- MSSQL support (#5659, Benedict Reuthlinger)

## [0.0.1] - 2016-10-06

### Added

- First initial release
