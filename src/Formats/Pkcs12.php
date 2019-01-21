<?php

namespace Exonet\SslConverter\Formats;

use Exonet\SslConverter\Exceptions\InvalidResource;
use Exonet\SslConverter\Exceptions\MissingRequiredInformation;

class Pkcs12 implements FormatInterface
{
    /**
     * @inheritdoc
     */
    public function export(Plain $certificate, array $options) : string
    {
        $key = $certificate->getKey();
        $crt = $certificate->getCrt();
        $caBundle = $certificate->getCaBundle();
        $password = isset($options['password']) ? $options['password'] : false;

        if (!$key || !$crt || !$caBundle || !$password) {
            throw new MissingRequiredInformation('The following fields are required for PKCS12: key, CRT, CA Bundle, password.');
        }

        if (!openssl_pkcs12_export($crt, $pkc12, $key, $password, ['extracerts' => $caBundle])) {
            throw new InvalidResource('Invalid certificate provided.');
        };

        return $pkc12;
    }

    /**
     * @inheritdoc
     */
    public function getPlain(array $options) : Plain
    {
        // TODO: Implement getPlain() method.
    }
}
