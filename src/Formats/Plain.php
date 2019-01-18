<?php

namespace Exonet\SslConverter\Formats;

class Plain implements FormatInterface
{
    /**
     * @var string The certificate string, typically the contents of the '.crt' file.
     */
    protected $crt;

    /**
     * @var string The private key to encrypt/decrypt the certificate typically the contents of the '.key' file.
     */
    protected $key;

    /**
     * @var string The certificate strings of the intermediate and/or the trusted root.
     */
    protected $caBundle;

    /**
     * @inheritdoc
     */
    public function export(Plain $certificate, array $options) : Plain
    {
        return $certificate;
    }

    /**
     * @inheritdoc
     */
    public function getPlain(array $options) : self
    {
        return $this;
    }

    /**
     * Get the crt of the certificate.
     *
     * @return string The crt of the certificate.
     */
    public function getCrt() : ?string
    {
        return $this->crt;
    }

    /**
     * Set the crt.
     *
     * @param string $crt The crt to set
     *
     * @return Plain The current instance of this class.
     */
    public function setCrt(string $crt) : self
    {
        $this->crt = $crt;

        return $this;
    }

    /**
     * Get the key of the certificate.
     *
     * @return string The key of the certificate.
     */
    public function getKey() : ?string
    {
        return $this->key;
    }

    /**
     * Set the key of the certificate.
     *
     * @param string $key The key of the certificate.
     *
     * @return Plain The current instance of this class.
     */
    public function setKey(string $key) : self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the CA bundle of the certificate.
     *
     * @return string The CA bundle of the certificate.
     */
    public function getCaBundle() : ?string
    {
        return $this->caBundle;
    }

    /**
     * Set the CA bundle of the certificate.
     *
     * @param string $caBundle The CA bundle of the certificate.
     *
     * @return Plain The current instance of this class.
     */
    public function setCaBundle(string $caBundle) : self
    {
        $this->caBundle = $caBundle;

        return $this;
    }
}
