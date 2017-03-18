# CRM - Composer Registry Manager

[![Build Status](https://img.shields.io/travis/slince/crm/master.svg?style=flat-square)](https://travis-ci.org/slince/crm)
[![Coverage Status](https://img.shields.io/codecov/c/github/slince/crm.svg?style=flat-square)](https://codecov.io/github/slince/crm)
[![Total Downloads](https://img.shields.io/packagist/dt/slince/crm.svg?style=flat-square)](https://packagist.org/packages/slince/crm)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/crm.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/crm)

CRM can help you easily and quickly switch between different composer registries, now include: [phpcomposer](http://www.phpcomposer.com/),[composer-proxy](https://www.composer-proxy.org/) 
and [packagist](https://packagist.org/)


## Install

Install via composer
```
composer global require slince/crm
```

## Example

List all available registries

```
$ crm ls

  composer       https://packagist.org
  phpcomposer    https://packagist.phpcomposer.com
* composer-proxy https://packagist.composer-proxy.org

```
If you want list all registries for the current project, you need add option `--current/-c`

```
$ crm ls -c

* composer       https://packagist.org
  phpcomposer    https://packagist.phpcomposer.com
  composer-proxy https://packagist.composer-proxy.org

```

Use registry

```
$ crm use phpcomposer

```
Likewise, add the option `--current/-c` for the current project.


Available commands:

```
$ crm --list

...

Available commands:
  add     Add one custom registry
  help    Displays help for a command
  list    Lists commands
  ls      List all available registries
  remove  Delete one custom registry
  reset   Reset registry configurations
  use     Change current registry to registry
```

## LICENSE

[MIT](https://opensource.org/licenses/MIT)