<?php

namespace Exonet\SslConverter\Formats;

use Exonet\SslConverter\Exceptions\InvalidResource;
use Exonet\SslConverter\Exceptions\MissingRequiredInformation;

class Pem implements FormatInterface
{
    /**
     * @inheritdoc
     */
    public function export(Plain $certificate, array $options) : string
    {
        $key = $certificate->getKey();
        $crt = $certificate->getCrt();
        $caBundle = $certificate->getCaBundle();

        if (!$crt || !$caBundle) {
            throw new MissingRequiredInformation('The following fields are required for PKCS12: CRT, CA Bundle.');
        }

        // If there is a key, prepend the certificate content with the key.
        $content = $key ? $key.$crt.$caBundle : $crt.$caBundle;
        if (!openssl_x509_read($content)) {
            throw new InvalidResource('Invalid certificate provided.');
        }

        return $content;
    }

    /**
     * @inheritdoc
     */
    public function getPlain(array $options) : Plain
    {
        // TODO: Implement getPlain() method.
    }
}
