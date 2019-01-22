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
            sprintf('%s.pem', $this->certificateName) => $this->toString(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function toString() : string
    {
        $key = $this->plainCertificate->getKey();
        $crt = $$this->plainCertificate->getCrt();
        $caBundle = $$this->plainCertificate->getCaBundle();

        if (!$crt || !$caBundle) {
            throw new MissingRequiredInformation('The following fields are required for PEM: CRT, CA Bundle.');
        }

        // If there is a key, prepend the certificate content with the key.
        $content = $key ? $key.$crt.$caBundle : $crt.$caBundle;
        if (!openssl_x509_read($content)) {
            throw new InvalidResource('Invalid certificate provided.');
        }

        return $content;
    }
}
