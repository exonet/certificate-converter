# SSL converter
PHP package to convert an SSL certificate to various formats (e.g PKC12, PEM).

## Install
Via Composer

``` bash
$ composer require exonet/ssl-converter
```

## Example usage
The example below shows how combine separate contents of a certificate to a combined PEM string.
 - `crt` The certificate (typically the contents of `.crt` file).
 - `key` The private key (typically the contents of the `.key` file)
 - `ca bundle` The certificate of the intermediate and/or the trusted root certificate

```php
// Initialise a new SSL converter.
$converter = new Converter();

// Setup the plain format class that should be converter.
$plain = new Plain();
$plain
    ->setKey('-----BEGIN PRIVATE KEY-----
...
-----END PRIVATE KEY-----
')
    ->setCrt('-----BEGIN CERTIFICATE-----
...
-----END CERTIFICATE-----
')
    ->setCaBundle('-----BEGIN CERTIFICATE-----
...
-----END CERTIFICATE-----
');

// Convert the plain certificate.
$pem = $converter
    ->from($plain)
    ->to(new Pem());
    
// Save as zip file:
$pem->asZip('./');

// Get an array with the certificate files:
print_r($pem->asFiles());

// Get the certificate as string:
print_r($pem->asString());
```

## Change log
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
