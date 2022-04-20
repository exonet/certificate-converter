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

        // Strip all kind of (wrong) newlines, indentations, etc. and create a correct certificate from the CRT.
        $x509cert = $this->cleanSection($crt);

        // Clean the newlines in the key.
        if ($key) {
            $x509key = $this->cleanSection($key, 'PRIVATE KEY');
        }

        // Clean the certificates in the CA bundle.
        $bundleCertificates = array_filter(explode('-----BEGIN CERTIFICATE-----', $caBundle));
        $newBundleCertificates = array_map(fn ($bundle): string => $this->cleanSection($bundle), $bundleCertificates);
        $caBundle = implode('', $newBundleCertificates);

        // If there is a key, prepend the certificate content with the key.
        $content = ($key ? $x509key : null).$x509cert.$caBundle;

        if (!openssl_x509_read($content)) {
            throw new InvalidResource('Invalid certificate provided.');
        }

        return $content;
    }
}
