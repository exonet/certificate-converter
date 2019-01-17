<?php

namespace Exonet\SslConverter\Formats;

interface FormatInterface
{
    public function export(Plain $certificate, array $options);

    public function getPlain() : Plain;
}
