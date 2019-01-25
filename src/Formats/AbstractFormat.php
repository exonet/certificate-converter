<?php

namespace Exonet\SslConverter\Formats;

use Exonet\SslConverter\Exceptions\NotImplementedException;

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
    public function setName(string $name) : FormatInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlain(Plain $plain) : FormatInterface
    {
        $this->plainCertificate = $plain;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options) : FormatInterface
    {
        $this->options = $options;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * @inheritdoc
     *
     * @throws NotImplementedException When this method is not implemented.
     */
    public function getPlain() : Plain
    {
        throw new NotImplementedException('The [getPlain] method is not implemented for this format.');
    }
}
