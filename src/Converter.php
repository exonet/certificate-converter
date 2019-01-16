<?php

namespace Exonet\SslConverter;

use Exonet\Format\FormatInterface;

class Converter
{
    /**
     * @param FormatInterface $input
     * @param FormatInterface $output
     * @param array           $options
     *
     * @return mixed
     */
    public function convert(FormatInterface $input, FormatInterface $output, array $options = [])
    {
        return $output->export($input->getPlain(), $options);
    }
}
