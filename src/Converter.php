<?php

namespace Exonet\SslConverter;

use Exonet\SslConverter\Formats\FormatInterface;

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
     * @var mixed[] Additional options that are needed to compose a certificate in a specific format.
     */
    protected $options = [
        'to' => [],
        'from' => [],
    ];

    /**
     * Set the format that should be converted.
     *
     * @param FormatInterface $from    The input format to be converted.
     * @param mixed[]         $options Additional options that are needed to compose a certificate in a specific format.
     *
     * @return Converter Instance of this class.
     */
    public function from(FormatInterface $from, array $options = []) : self
    {
        $this->from = $from;
        $this->options['from'] = $options;

        return $this;
    }

    /**
     * Set the format that should be converted to.
     *
     * @param FormatInterface $to      The output format to convert to.
     * @param mixed[]         $options Additional options that are needed to compose a certificate in a specific format.
     *
     * @return Converter Instance of this class
     */
    public function to(FormatInterface $to, array $options = []) : self
    {
        $this->to = $to;
        $this->options['to'] = $options;

        return $this;
    }

    /**
     * Convert the input format to the provided output format as a string.
     *
     * @return string The converted format in a string that can be saved to a file.
     */
    public function convertToString() : string
    {
        $plain = $this->from->getPlain($this->options['from']);

        return $this->to->export($plain, $this->options['to']);
    }
}
