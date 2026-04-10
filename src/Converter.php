<?php

namespace Exonet\CertificateConverter;

use Exonet\CertificateConverter\Exceptions\ZipException;
use Exonet\CertificateConverter\Formats\FormatInterface;

class Converter
{
    /**
     * @var FormatInterface The input format to be converted.
     */
    protected $to;

    /**
     * @var FormatInterface The output format to convert to.
     */
    protected $from;

    /**
     * @var string The certificate name.
     */
    protected $certificateName = 'certificate';

    /**
     * Set the name of the certificate.
     *
     * @param string $certificateName The certificate.
     *
     * @return $this The current Converter instance.
     */
    public function setName(string $certificateName): self
    {
        $this->certificateName = $certificateName;

        return $this;
    }

    /**
     * Set the format that should be converted.
     *
     * @param FormatInterface $from The input format to be converted.
     *
     * @return $this Instance of this class.
     */
    public function from(FormatInterface $from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the format that should be converted to.
     *
     * @param FormatInterface $to The output format to convert to.
     *
     * @return $this Instance of this class
     */
    public function to(FormatInterface $to): self
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Convert the input format to the provided output format as a string.
     *
     * @throws Exceptions\InvalidResource            When the provided certificate is invalid.
     * @throws Exceptions\MissingRequiredInformation When some required certificate data is missing.
     *
     * @return string The converted format as a string that can be saved to a file.
     */
    public function asString(): string
    {
        return $this->to
            ->setName($this->certificateName)
            ->setPlain($this->from->getPlain())
            ->toString();
    }

    /**
     * Convert the input format to the provided output format as an array of files. The array key is the file name, the
     * array value the file contents.
     *
     * @throws Exceptions\InvalidResource            When the provided certificate is invalid.
     * @throws Exceptions\MissingRequiredInformation When some required certificate data is missing.
     *
     * @return string[] The converted format as an array of files that can be saved to a file.
     */
    public function asFiles(): array
    {
        return $this->to
            ->setName($this->certificateName)
            ->setPlain($this->from->getPlain())
            ->export();
    }

    /**
     * Convert the input format to the provided output format and zip the files.
     *
     * @throws Exceptions\InvalidResource            When the provided certificate is invalid.
     * @throws Exceptions\MissingRequiredInformation When some required certificate data is missing.
     * @throws ZipException                          When the files can not be zipped.
     *
     * @return \SplTempFileObject The zip file.
     */
    public function asZip(): \SplTempFileObject
    {
        $tempPath = tempnam(sys_get_temp_dir(), 'zip_');

        $zip = new \ZipArchive();
        $zip->open($tempPath, \ZipArchive::CREATE);

        foreach ($this->asFiles() as $name => $content) {
            $zip->addFromString($name, $content);
        }

        if ($zip->status !== 0) {
            throw new ZipException($zip->getStatusString());
        }

        $zip->close();

        $zipTempFile = new \SplTempFileObject();
        $zipTempFile->fwrite(file_get_contents($tempPath));
        $zipTempFile->rewind();

        return $zipTempFile;
    }
}
