# CRM - Composer源管理工具

[![Build Status](https://img.shields.io/travis/slince/composer-registry-manager/master.svg?style=flat-square)](https://travis-ci.org/slince/composer-registry-manager)
[![Coverage Status](https://img.shields.io/codecov/c/github/slince/composer-registry-manager.svg?style=flat-square)](https://codecov.io/github/slince/composer-registry-manager)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/composer-registry-manager.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/composer-registry-manager)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/slince/composer-registry-manager.svg?style=flat-square)](https://scrutinizer-ci.com/g/slince/composer-registry-manager/?branch=master)

由于composer在国内下载速度非常慢，大家都习惯使用中国镜像，如果正在使用的镜像没有更新或者出现故障你可以使用Composer Registry Manager帮助你轻松地切换到另外一个镜像。
默认带了四个镜像:

- https://packagist.org (官方)
- https://packagist.phpcomposer.com
- https://packagist.composer-proxy.org
- https://packagist.laravel-china.org

![Screenshot](./assets/screenshot.gif)

## 安装

使用composer安装，执行下面命令

```bash
$ composer global require slince/composer-registry-manager
```

## 基本用法

### 列出所有可使用的镜像

```bash
$ crm ls

  composer       https://packagist.org
  phpcomposer    https://packagist.phpcomposer.com
* composer-proxy https://packagist.composer-proxy.org
  laravel-china  https://packagist.laravel-china.org
```
标“*”表示当前正在使用的源，如果你需要标注当前项目正在使用的源，你需要在命令后面追加选项 `--current/-c`

```bash
$ crm ls -c

* composer       https://packagist.org
  phpcomposer    https://packagist.phpcomposer.com
  composer-proxy https://packagist.composer-proxy.org
  laravel-china  https://packagist.laravel-china.org
```

### 切换镜像

```bash
$ crm use
Please select your favorite registry (defaults to composer)
  [0] composer
  [1] phpcomposer
  [2] composer-proxy
  [3] laravel-china
 >
```
你也可以直接追加镜像名称来跳过选择

```bash
$ crm use composer-proxy
```

同样，添加选项 `--current/-c` 为当前项目切换源。


### 所有命令

执行下面命令查看

```bash
$ crm
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