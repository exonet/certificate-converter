<?php

namespace Exonet\SslConverter;

use Exonet\SslConverter\Formats\FormatInterface;

class Converter
{
    /**
     * @var FormatInterface
     */
    protected $to;

    /**
     * @var FormatInterface
     */
    protected $from;

    /**
     * @var array
     */
    protected $options = [
        'to' => [],
        'from' => [],
    ];

    /**
     * @param FormatInterface $input
     * @param FormatInterface $output
     * @param array           $options
     *
     * @return mixed
     */
    public function from(FormatInterface $from,  array $options = []) : self
    {
        $this->from = $from;
        $this->options['from'] = $options;

        return $this;
    }

    /**
     * @param FormatInterface $to
     * @param array           $options
     *
     * @return Converter
     */
    public function to(FormatInterface $to, array $options = []) : self
    {
        $this->to = $to;
        $this->options['to'] = $options;

        return $this;
    }

    /**
     * @return mixed
     */
    public function convert()
    {
        $plain = $this->from->getPlain($this->options['from']);

        return $this->to->export($plain, $this->options['to']);
    }
}
