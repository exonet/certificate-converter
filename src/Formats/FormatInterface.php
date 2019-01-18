<?php

namespace Exonet\SslConverter\Formats;

use Exonet\SslConverter\Exceptions\InvalidResource;
use Exonet\SslConverter\Exceptions\MissingRequiredInformation;

interface FormatInterface
{
    /**
     * Export the format to a string that can be saved to a file.
     *
     * @param Plain $certificate The plain version of the input format that should be converted.
     * @param array $options Additional options that are needed to compose the certificate to the new format.
     *
     * @return string The format as a string that can be saved to a file.
     *
     * @throws InvalidResource When the provided certificate is invalid.
     * @throws MissingRequiredInformation When some required certificate data is missing.
     */
    public function export(Plain $certificate, array $options) : string;

    /**
     * Return a plain instance of this format version.
     *
     * @param array $options Additional options that are needed to compose the certificate in a plain format.
     *
     * @return Plain The plain instance of this format.
     */
    public function getPlain(array $options) : Plain;
}
