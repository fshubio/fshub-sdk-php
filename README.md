# FsHub PHP SDK

[![build](https://github.com/fshubio/fshub-sdk-php/actions/workflows/build.yml/badge.svg?branch=main)](https://github.com/fshubio/fshub-sdk-php/actions/workflows/build.yml)

This repository contains the official PHP SDK client for the FsHub platform integration services.

> This client library (SDK) is supported on PHP 8.0+

This SDK is available to download using Composer into your own projects, the package repository can be found
here:

https://tbc

## Publishing the package to Packagist

Publishing to Packagist is fully automatic when a new GitHub "release" is published and requires zero manual steps.

## Examples

```php
<?php

namespace YouProjectNamespace;

use FsHub\Sdk\Client;

$fshub = new Client('YOUR_API_KEY_HERE');

$airport = $fshub->airport->find('EGSS');

// @todo I will update example when I have completed more of the library.
```