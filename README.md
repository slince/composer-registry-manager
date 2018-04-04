# CRM - Composer Registry Manager

[![Build Status](https://img.shields.io/travis/slince/composer-registry-manager/master.svg?style=flat-square)](https://travis-ci.org/slince/composer-registry-manager)
[![Coverage Status](https://img.shields.io/codecov/c/github/slince/composer-registry-manager.svg?style=flat-square)](https://codecov.io/github/slince/composer-registry-manager)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/composer-registry-manager.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/composer-registry-manager)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/slince/composer-registry-manager.svg?style=flat-square)](https://scrutinizer-ci.com/g/slince/composer-registry-manager/?branch=master)

Composer Registry Manager can help you easily and quickly switch between different composer repositories.

[简体中文](./README-zh_CN.md)

## Installation

Install via composer

```bash
$ composer global require slince/composer-registry-manager ^2.0
```

## Example

### List all available repositories

```bash
$ composer repo:ls

  composer       https://packagist.org
  phpcomposer    https://packagist.phpcomposer.com
* composer-proxy https://packagist.composer-proxy.org
  laravel-china  https://packagist.laravel-china.org
```

### Switch repository

```bash
$ composer repo:use
Please select your favorite registry (defaults to composer)
  [0] composer
  [1] phpcomposer
  [2] composer-proxy
  [3] laravel-china
 >
```
You can also skip selection by giving repository name.

```bash
$ composer repo:use phpcomposer
```
Add the option `--current/-c` for the current project.

### Available commands

Use the following command for help.

```bash
$ composer repo
 _____   _____        ___  ___
/  ___| |  _  \      /   |/   |
| |     | |_| |     / /|   /| |
| |     |  _  /    / / |__/ | |
| |___  | | \ \   / /       | |
\_____| |_|  \_\ /_/        |_|

Composer Repository Manager version 2.0.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands for the "repo" namespace:
  repo:add     Creates a repository
  repo:ls      List all available repositories
  repo:remove  Remove a repository
  repo:use     Change current repository
```

## LICENSE

The MIT license. See [MIT](https://opensource.org/licenses/MIT)