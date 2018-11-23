# M2 Pincodes module

### Installation

With composer:

```sh
$ composer config repositories.ambab composer https://pack.ambab.com/
$ composer require ambab/pincodes:dev-master
```

Manually:

Copy the zip into app/code/Ambab/Pincodes directory


#### After installation by either means, enable the extension by running following commands:

```sh
$ php bin/magento module:enable ambab_pincodes --clear-static-content
$ php bin/magento setup:upgrade
```

#### After module is enable make sure following points

1. Some js/html template related to checkout has been extended. To view all js look into requirejs-config.js.
2. If listes js/html template on requirejs-config.js has already been extended. Please merge the change to your extended js/html files.

#### Note :
If any changes according to project requirement needs to be done, extend the vendor file to app/code.