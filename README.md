# crm -- composer registry manager

crm can help you easy and fast switch between different npm registries, now include: [phpcomposer](http://www.phpcomposer.com/),[composer-proxy](https://www.composer-proxy.org/) 
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

Use registry

```
$ crm use phpcomposer

```

...

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

Apache-2.0