<?php

namespace Exonet\SslConverter\Formats;

use Exonet\SslConverter\Exceptions\MissingRequiredInformation;

class Pkcs12 implements FormatInterface
{
    public function export(Plain $certificate, array $options) : string
    {
        $key = $certificate->getKey();
        $crt = $certificate->getCrt();
        $caBundle = $certificate->getCaBundle();
        $password = isset($options['password']) ? $options['password'] : false;

        if (!$key || !$crt || !$caBundle || !$password) {
            throw new MissingRequiredInformation();
        }

        if (!openssl_pkcs12_export($crt, $pkc12, $key, $password, ['extracerts' => $caBundle])) {
            throw new InvalidArgumentException('Invalid certificate provided.');
        };

        return $pkc12;
    }
}
