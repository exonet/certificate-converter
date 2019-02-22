<?php

namespace Exonet\SslConverter\Formats;

use Exonet\SslConverter\Exceptions\InvalidResource;
use Exonet\SslConverter\Exceptions\MissingRequiredInformation;

class Pem extends AbstractFormat
{
    /**
     * @inheritdoc
     */
    public function export() : array
    {
        return [
            $this->name.'.pem' => $this->toString(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function toString() : string
    {
        $key = $this->plainCertificate->getKey();
        $crt = $this->plainCertificate->getCrt();
        $caBundle = $this->plainCertificate->getCaBundle();

        if (!$crt || !$caBundle) {
            throw new MissingRequiredInformation('The following fields are required for PEM: CRT, CA Bundle.');
        }

        // Strip all kind of (wrong) newlines, indentations, etc. and create a correct certificate from the CRT.
        $x509cert = str_replace(array("\x0D", "\r", "\n", '\n', '\r'), '', $crt);
        $x509cert = str_replace('-----BEGIN CERTIFICATE-----', "", $x509cert);
        $x509cert = str_replace('-----END CERTIFICATE-----', "", $x509cert);
        $x509cert = str_replace(' ', '', $x509cert);
        $x509cert = "-----BEGIN CERTIFICATE-----\n".chunk_split($x509cert, 64, "\n")."-----END CERTIFICATE-----\n";

        $content = $key ? $key.$x509cert.$caBundle : $x509cert.$caBundle;

        // If there is a key, prepend the certificate content with the key.
        if (!openssl_x509_read($content)) {
            throw new InvalidResource('Invalid certificate provided.');
        }

        return $content;
    }
}
