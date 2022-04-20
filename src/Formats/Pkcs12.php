<?php

namespace Exonet\CertificateConverter\Formats;

use Exonet\CertificateConverter\Exceptions\InvalidResource;
use Exonet\CertificateConverter\Exceptions\MissingRequiredInformation;

class Pkcs12 extends AbstractFormat
{
    /**
     * {@inheritdoc}
     */
    public function export(): array
    {
        return [
            $this->name.'.pfx' => $this->toString(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        $key = $this->plainCertificate->getKey();
        $crt = $this->plainCertificate->getCrt();
        $caBundle = $this->plainCertificate->getCaBundle();
        $password = $this->options['password'] ?? false;

        if (!$key || !$crt || !$caBundle || !$password) {
            throw new MissingRequiredInformation('The following fields are required for PKCS12: key, CRT, CA Bundle, password.');
        }

        if (!openssl_pkcs12_export($crt, $pkc12, $key, $password, ['extracerts' => $caBundle])) {
            throw new InvalidResource('Invalid certificate provided.');
        }

        return $pkc12;
    }
}
