<?php

namespace Exonet\Format;

class Php implements FormatInterface
{
    protected $crt;

    protected $key;

    protected $ca;

    public function export(Php $certificate, array $options) : Php {
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
    public function getCa() : ?string
    {
        return $this->ca;
    }

    /**
     * @param string $ca
     *
     * @return Certificate
     */
    public function setCa($ca) : self
    {
        $this->ca = $ca;

        return $this;
    }
}
