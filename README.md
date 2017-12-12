# Derived unique key per transaction
[![License](https://img.shields.io/github/license/tonicforhealth/dukpt.svg?maxAge=2592000)](LICENSE)
[![Packagist](https://img.shields.io/packagist/v/tonicforhealth/dukpt.svg?maxAge=2592000)](https://packagist.org/packages/tonicforhealth/dukpt)
[![Build Status](https://travis-ci.org/tonicforhealth/dukpt.svg?branch=master)](https://travis-ci.org/tonicforhealth/dukpt)
[![Code Coverage](https://scrutinizer-ci.com/g/tonicforhealth/dukpt/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tonicforhealth/dukpt/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tonicforhealth/dukpt/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tonicforhealth/dukpt/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/32629a10-0651-4aa9-a13a-53182bbc1c19/mini.png)](https://insight.sensiolabs.com/projects/32629a10-0651-4aa9-a13a-53182bbc1c19)

In cryptography, Derived Unique Key Per Transaction (DUKPT) is a key management scheme in which for every transaction,
a unique key is used which is derived from a fixed key. Therefore, if a derived key is compromised,
future and past transaction data are still protected since the next or prior keys cannot be determined easily.
DUKPT is specified in ANSI X9.24 part 1.

## Installation using [Composer](http://getcomposer.org/)

```bash
$ composer require tonicforhealth/dukpt
```

## Usage

```php
<?php

use TonicForHealth\DUKPT\Device\PinEncryptionDevice;
use TonicForHealth\DUKPT\DUKPTFactory;

$cipherText = '160954FE1071D30C5CF260C5AC48EB5FBEFE37B32033E3B7EF693F8C6AB1BBD6276446FB3689728B926D923CD9ECCD522B6DE5850FD9AB2D7976D943C12CDC947E023098CAAE4F6D';

$device = new PinEncryptionDevice(new DUKPTFactory());
$device->load('0123456789ABCDEFFEDCBA9876543210', 'FFFF9876543210E00008');

$plainText = $device->decrypt($cipherText); // %B4124939999999990^TEST/TESTCARD^19129015432139614567891234567890?
```

## Articles

- ["How to decrypt magnetic card data with DUKPT"](https://www.parthenonsoftware.com/blog/how-to-decrypt-magnetic-stripe-scanner-data-with-dukpt/) - *Travis Hoffman*
