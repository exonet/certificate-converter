<?php

namespace Exonet\SslConverter\Formats;

class Plain implements FormatInterface
{
    protected $crt;

    protected $key;

    protected $caBundle;

    public function export(Plain $certificate, array $options) : Plain
    {
        return $certificate;
    }

    public function getPlain() : self
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getCrt() : ?string
    {
        return $this->crt;
    }

    /**
     * @param string $crt
     *
     * @return Certificate
     */
    public function setCrt($crt) : self
    {
        $this->crt = $crt;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey() : ?string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return Certificate
     */
    public function setKey($key) : self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string
     */
    public function getCaBundle() : ?string
    {
        return $this->caBundle;
    }

    /**
     * @param $caBundle
     *
     * @return Plain
     */
    public function setCaBundle($caBundle) : self
    {
        $this->caBundle = $caBundle;

        return $this;
    }
}
