# CRM - Composer Registry Manager

[![Build Status](https://img.shields.io/github/actions/workflow/status/slince/composer-registry-manager/test.yml?style=flat-square)](https://github.com/slince/composer-registry-manager/actions)
[![Coverage Status](https://img.shields.io/codecov/c/github/slince/composer-registry-manager.svg?style=flat-square)](https://codecov.io/github/slince/composer-registry-manager)
[![Total Downloads](https://img.shields.io/packagist/dt/slince/composer-registry-manager.svg?style=flat-square)](https://packagist.org/packages/slince/composer-registry-manager)
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

 --- ------------- ------------------------------------------------ ------------------------------
      composer      https://packagist.org                            Europe, Canada and Singapore
      aliyun        https://mirrors.aliyun.com/composer              China
      tencent       https://mirrors.cloud.tencent.com/composer       China
  *   huawei        https://mirrors.huaweicloud.com/repository/php   China
      cnpkg         https://php.cnpkg.org                            China
      sjtug         https://packagist.mirrors.sjtug.sjtu.edu.cn      China
      phpcomposer   https://packagist.phpcomposer.com                China
      kkame         https://packagist.kr                             South Korea
      hiraku        https://packagist.jp                             Japan
      webysther     https://packagist.com.br                         Brazil
      solidworx     https://packagist.co.za                          South Africa
      indra         https://packagist.phpindonesia.id                Indonesia
      varun         https://packagist.in                             India
 --- ------------- ------------------------------------------------ ------------------------------
```

You can filter by location using `--location xx`

```bash
$ composer repo:ls --location China
```

### Switch repository

```bash
$ composer repo:use

Please select your favorite repository (defaults to composer) [composer]:
  [0 ] composer
  [1 ] aliyun
  [2 ] tencent
  [3 ] huawei
  [4 ] cnpkg
  [5 ] sjtug
  [6 ] phpcomposer
  [7 ] kkame
  [8 ] hiraku
  [9 ] webysther
  [10] solidworx
  [11] indra
  [12] varun
>
```
You can also skip selection by giving repository name.

```bash
$ composer repo:use aliyun
```
Add the option `--current/-c` for the current project.

### Reset command

If you want to discard all custom mirrors, you can use the following command:

```bash
$ composer repo:reset
```

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
