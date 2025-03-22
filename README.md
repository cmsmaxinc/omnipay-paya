# Omnipay: Paya

**Paya gateway for the Omnipay PHP payment processing library**

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment processing library for PHP. This package implements Paya (Nuvei) support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply require `league/omnipay` and `cmsmaxinc/omnipay-paya` with Composer:

```bash
composer require league/omnipay cmsmaxinc/omnipay-paya
```

## Basic Usage

The following gateways are provided by this package:

* Paya

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay) repository.

### Gateway Parameters

The following parameters are required when creating the gateway:

* `merchantId` - Your paya merchant ID
* `username` - Your paya API username
* `password` - Your paya API password
* `productionWsdlUrl` 
* `sandboxWsdlUrl`

Additionally, you can set:

* `testMode` - Set to true to use the sandbox environment

### Available Methods

The gateway supports the following methods:

* `purchase()` - Authorize and capture a payment
* `refund()` - Refund a previously captured payment

## Sandbox Testing

paya provides a sandbox environment for testing your integration. To use the sandbox:

1. Set the gateway to test mode:
   ```php
   $gateway->setTestMode(true);
   ```

2. Use the sandbox credentials provided by paya:
   ```php
   $gateway->setMerchantId('your-test-merchant-id');
   $gateway->setUsername('your-test-username');
   $gateway->setPassword('your-test-password');
   $gateway->setProductionWsdlUrl('');
   $gateway->setSandboxWsdlUrl('');
   ```

3. Set ACH account credentials
   ```php
   $achAccount = $gateway->createAchAccount([
      // Bank account details
      'routingNumber' => '123456789',
      'accountNumber' => '987654321',
      'accountType' => 'Checking',
      
      // Customer information
      'firstName' => 'John',
      'lastName' => 'Doe',
      'billingAddress1' => '123 Main Street',
      'billingAddress2' => 'Apt 456',
      'billingCity' => 'Anytown',
      'billingState' => 'CA',
      'billingPostcode' => '12345',
      'phone' => '555-123-4567',
      
      // Optional verification information
      'dlState' => 'CA',
      'dlNumber' => 'D1234567',
      'courtesyCardId' => 'CC12345'
   ]);

   // Process a purchase transaction
   $purchaseResponse = $gateway->purchase([
      'requestId' => uniqid(),
      'transactionId' => 'INV-' . time(),
      'amount' => '50.00',
      'achAccount' => $achAccount
   ])->send();
   ```


## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/online-postal-scanning/omnipay-paya/issues),
or better yet, fork the library and submit a pull request.