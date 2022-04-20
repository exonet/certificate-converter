<?php

namespace Exonet\CertificateConverter\Formats;

use Exonet\CertificateConverter\Exceptions\NotImplementedException;

abstract class AbstractFormat implements FormatInterface
{
    /**
     * @var Plain The plain certificate required for exporting.
     */
    protected $plainCertificate;

    /**
     * @var mixed[] List with options for the format.
     */
    protected $options = [];

    /**
     * @var string The certificate name.
     */
    protected $name = 'certificate';

    /**
     * AbstractFormat constructor.
     *
     * @param mixed[] $options The (optional) array with options for this format.
     */
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name): FormatInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlain(Plain $plain): FormatInterface
    {
        $this->plainCertificate = $plain;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options): FormatInterface
    {
        $this->options = $options;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     *
     * @throws NotImplementedException When this method is not implemented.
     */
    public function getPlain(): Plain
    {
        throw new NotImplementedException('The [getPlain] method is not implemented for this format.');
    }

    /**
     * Clean and format a section.
     *
     * Replace newline and whitespace characters.
     * Turn into 64 characters per line.
     *
     * @param string $certificate       The certificate or key to clean.
     * @param string $sectionIdentifier The identifier to find the start and end.
     *
     * @return string The formatted certificate/key.
     */
    protected function cleanSection(string $certificate, $sectionIdentifier = 'CERTIFICATE'): string
    {
        $possibleNewLines = ["\x0D", "\r", "\n", '\n', '\r'];

        $x509cert = str_replace($possibleNewLines, '', $certificate);
        $x509cert = str_replace('-----BEGIN '.$sectionIdentifier.'-----', '', $x509cert);
        $x509cert = str_replace('-----END '.$sectionIdentifier.'-----', '', $x509cert);
        $x509cert = str_replace(' ', '', $x509cert);

        return '-----BEGIN '.$sectionIdentifier."-----\n".chunk_split($x509cert, 64, "\n").'-----END '.$sectionIdentifier."-----\n";
    }
}
