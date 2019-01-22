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
     * @var array List with options for the format.
     */
    protected $options = [];

    /**
     * @var string The certificate name.
     */
    protected $certificateName = 'certificate';

    /**
     * AbstractFormat constructor.
     *
     * @param array $options The (optional) array with options for this format.
     */
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $certificateName) : FormatInterface
    {
        $this->certificateName = $certificateName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->certificateName;
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
     * @inheritdoc
     *
     * @throws NotImplementedException As long as this method is not implemented.
     */
    public function getPlain() : Plain
    {
        throw new NotImplementedException('The [getPlain] method is not implemented for this format.');
    }
}
