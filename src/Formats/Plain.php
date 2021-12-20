<?php

namespace Exonet\SslConverter\Formats;

class Plain extends AbstractFormat
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
     * {@inheritdoc}
     */
    public function export(): array
    {
        $files = [];

        // Add the key only if it is not empty.
        if (!empty($this->plainCertificate->getKey())) {
            $files[$this->name.'.key'] = $this->plainCertificate->getKey();
        }

        $files[$this->name.'.crt'] = $this->plainCertificate->getCrt();
        $files[$this->name.'.ca-bundle'] = $this->plainCertificate->getCaBundle();

        return $files;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->plainCertificate->getCrt().$this->plainCertificate->getKey().$this->plainCertificate->getCaBundle();
    }

    /**
     * {@inheritdoc}
     */
    public function getPlain(): self
    {
        return $this;
    }

    /**
     * Get the crt.
     *
     * @return string The crt.
     */
    public function getCrt(): ?string
    {
        return $this->crt;
    }

    /**
     * Set the crt.
     *
     * @param string $crt The crt to set
     *
     * @return $this The current instance of this class.
     */
    public function setCrt(string $crt): self
    {
        $this->crt = $crt;

        return $this;
    }

    /**
     * Get the key.
     *
     * @return string The key.
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * Set the key.
     *
     * @param string $key The key.
     *
     * @return $this The current instance of this class.
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the CA bundle.
     *
     * @return string The CA bundle.
     */
    public function getCaBundle(): ?string
    {
        return $this->caBundle;
    }

    /**
     * Set the CA bundle.
     *
     * @param string $caBundle The CA bundle.
     *
     * @return $this The current instance of this class.
     */
    public function setCaBundle(string $caBundle): self
    {
        $this->caBundle = $caBundle;

        return $this;
    }
}
