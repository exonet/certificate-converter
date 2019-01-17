<?php

namespace Exonet\SslConverter\Formats;

use Exonet\SslConverter\Exceptions\MissingRequiredInformation;
use InvalidArgumentException;

class Pem implements FormatInterface
{
    /**
     * @param Plain   $certificate
     * @param array $options
     *
     * @return string
     *
     * @throws MissingRequiredInformation
     */
    public function export(Plain $certificate, array $options) : string
    {
        $key = $certificate->getKey();
        $crt = $certificate->getCrt();
        $caBundle = $certificate->getCaBundle();

        if (!$crt || !$caBundle) {
            throw new MissingRequiredInformation();
        }

        // If there is a key, prepend the certificate content with the key.
        $content = $key ? $key.$crt.$caBundle : $crt.$caBundle;
        if (!openssl_x509_read($content)) {
            throw new InvalidArgumentException('Invalid certificate provided');
        }

        return $content;
    }

    public function getPlain() : Plain
    {
        // TODO: Implement getPlain() method.
    }
}
