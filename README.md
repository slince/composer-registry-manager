# CRM - Composer Registry Manager

[![Build Status](https://img.shields.io/travis/slince/composer-registry-manager/master.svg?style=flat-square)](https://travis-ci.org/slince/composer-registry-manager)
[![Coverage Status](https://img.shields.io/codecov/c/github/slince/composer-registry-manager.svg?style=flat-square)](https://codecov.io/github/slince/composer-registry-manager)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/composer-registry-manager.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/composer-registry-manager)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/slince/composer-registry-manager.svg?style=flat-square)](https://scrutinizer-ci.com/g/slince/composer-registry-manager/?branch=master)

Composer Registry Manager can help you easily and quickly switch between different composer registries.

## Installation

Install via composer

```bash
$ composer global require slince/composer-registry-manager
```

## Example

### List all available registries

```bash
$ crm ls

  composer       https://packagist.org
  phpcomposer    https://packagist.phpcomposer.com
* composer-proxy https://packagist.composer-proxy.org

```
If you want list all registries for the current project, you need add option `--current/-c`

```bash
$ crm ls -c

* composer       https://packagist.org
  phpcomposer    https://packagist.phpcomposer.com
  composer-proxy https://packagist.composer-proxy.org

```

### Switch registry

```bash
$ crm use phpcomposer
```
Likewise, add the option `--current/-c` for the current project.


### Available commands

Use the following command for help.

```bash
$ crm -l
 _____   _____        ___  ___
/  ___| |  _  \      /   |/   |
| |     | |_| |     / /|   /| |
| |     |  _  /    / / |__/ | |
| |___  | | \ \   / /       | |
\_____| |_|  \_\ /_/        |_|

Composer Registry Manager 1.2.0 by Tao and contributors.

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

Available commands:
  add     Add one custom registry
  help    Displays help for a command
  list    Lists commands
  ls      List all available registries
  remove  Delete one custom registry
  reset   Reset registry configurations
  use     Change current registry
```

## LICENSE

The MIT license. See [MIT](https://opensource.org/licenses/MIT)