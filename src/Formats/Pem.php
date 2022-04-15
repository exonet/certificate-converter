<?php

namespace Exonet\CertificateConverter\Formats;

use Exonet\CertificateConverter\Exceptions\InvalidResource;
use Exonet\CertificateConverter\Exceptions\MissingRequiredInformation;

class Pem extends AbstractFormat
{
    /**
     * {@inheritdoc}
     */
    public function export(): array
    {
        return [
            $this->name.'.pem' => $this->toString(),
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

        if (!$crt || !$caBundle) {
            throw new MissingRequiredInformation('The following fields are required for PEM: CRT, CA Bundle.');
        }

        $possibleNewLines = ["\x0D", "\r", "\n", '\n', '\r'];

        // Strip all kind of (wrong) newlines, indentations, etc. and create a correct certificate from the CRT.
        $x509cert = str_replace($possibleNewLines, '', $crt);
        $x509cert = str_replace('-----BEGIN CERTIFICATE-----', '', $x509cert);
        $x509cert = str_replace('-----END CERTIFICATE-----', '', $x509cert);
        $x509cert = str_replace(' ', '', $x509cert);
        $x509cert = "-----BEGIN CERTIFICATE-----\n".chunk_split($x509cert, 64, "\n")."-----END CERTIFICATE-----\n";

        // Clean the newlines in the key.
        if ($key) {
            $x509key = str_replace($possibleNewLines, '', $key);
            $x509key = str_replace('-----BEGIN PRIVATE KEY-----', '', $x509key);
            $x509key = str_replace('-----END PRIVATE KEY-----', '', $x509key);
            $x509key = str_replace(' ', '', $x509key);
            $x509key = "-----BEGIN PRIVATE KEY-----\n".chunk_split($x509key, 64, "\n")."-----END PRIVATE KEY-----\n";
        }

        // If there is a key, prepend the certificate content with the key.
        $content = $key ? $x509key.$x509cert.$caBundle : $x509cert.$caBundle;

        if (!openssl_x509_read($content)) {
            throw new InvalidResource('Invalid certificate provided.');
        }

        return $content;
    }
}
