<?php

namespace Exonet\CertificateConverter\Formats;

use Exonet\CertificateConverter\Exceptions\InvalidResource;
use Exonet\CertificateConverter\Exceptions\MissingRequiredInformation;

interface FormatInterface
{
    /**
     * Set the certificate name.
     *
     * @param string $certificateName The certificate name.
     *
     * @return $this The current format instance.
     */
    public function setName(string $certificateName): FormatInterface;

    /**
     * Get the certificate name.
     *
     * @return string The certificate name.
     */
    public function getName(): string;

    /**
     * Export the format to an array with the certificate data.
     *
     * @throws InvalidResource            When the provided certificate is invalid.
     * @throws MissingRequiredInformation When some required certificate data is missing.
     *
     * @return string[] A list with the certificate files. The key is the file name, the value the file contents.
     */
    public function export(): array;

    /**
     * Export the format to a string that can be saved to a file.
     *
     * @throws InvalidResource            When the provided certificate is invalid.
     * @throws MissingRequiredInformation When some required certificate data is missing.
     *
     * @return string The format as a string that can be saved to a file.
     */
    public function toString(): string;

    /**
     * Return a plain instance of this format version.
     *
     * @return Plain The plain instance of this format.
     */
    public function getPlain(): Plain;

    /**
     * Set the plain instance of this format version.
     *
     * @param Plain $plain The plain instance of this format.
     *
     * @return $this The current format instance.
     */
    public function setPlain(Plain $plain): FormatInterface;

    /**
     * Set the options for this format version.
     *
     * @param mixed[] $options The options.
     *
     * @return $this The current format instance.
     */
    public function setOptions(array $options): FormatInterface;

    /**
     * Get the options for this format version.
     *
     * @return mixed[] The options set for this format.
     */
    public function getOptions(): array;
}
