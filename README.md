# Certificate converter
PHP package to convert an SSL certificate to various formats (e.g PKC12, PEM).

## Install
Via Composer

``` bash
$ composer require exonet/certificate-converter
```

## Example usage
The example below shows how combine separate contents of a certificate to a combined PEM string.
 - `crt` The certificate (typically the contents of `.crt` file).
 - `key` The private key (typically the contents of the `.key` file)
 - `ca bundle` The certificate of the intermediate and/or the trusted root certificate

```php
// Initialise a new certificate converter.
$converter = new Converter();

// Setup the plain format class that should be converted.
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

// Convert the plain certificate to PEM.
$pem = $converter
    ->from($plain)
    ->to(new Pem());

// Save as zip file.
$pem->asZip('./');

// Get an array with the certificate files:
print_r($pem->asFiles());

// Get the certificate as string:
print_r($pem->asString());
```

## Change log
Please see [releases](https://github.com/exonet/certificate-converter/releases) for more information on what has changed recently.
