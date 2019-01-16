<?php

namespace Exonet\Format;

interface FormatInterface
{
    public function export(Php $certificate, array $options);

    public function getPlain() : Php;
}
