<?php

namespace Exonet\CertificateConverter\tests;

use Exonet\CertificateConverter\Converter;
use Exonet\CertificateConverter\Formats\Pem;
use Exonet\CertificateConverter\Formats\Plain;
use Exonet\CertificateConverter\tests\Inputs\TestCertificate;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ConverterTest extends TestCase
{
    public function testPlainToPemString()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setKey(TestCertificate::KEY)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $converter = (new Converter())
            ->from($plain)
            ->to(new Pem());

        $this->assertSame(
            TestCertificate::KEY.TestCertificate::CRT.TestCertificate::CA_BUNDLE,
            $converter->asString()
        );
    }

    public function testPlainToPemFile()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setKey(TestCertificate::KEY)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $converter = (new Converter())
            ->from($plain)
            ->setName('example.com')
            ->to(new Pem());

        $this->assertSame(
            [
                'example.com.pem' => TestCertificate::KEY.TestCertificate::CRT.TestCertificate::CA_BUNDLE,
            ],
            $converter->asFiles()
        );
    }

    public function testPlainToPemZip()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setKey(TestCertificate::KEY)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $converter = (new Converter())
            ->from($plain)
            ->setName('example.com')
            ->to(new Pem());

        $converter->asZip(__DIR__);

        $this->assertTrue(file_exists(__DIR__.'/example.com.zip'));

        unlink(__DIR__.'/example.com.zip');
    }

    public function testPlainToPlainString()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setKey(TestCertificate::KEY)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $converter = (new Converter())
            ->from($plain)
            ->to(new Plain());

        $this->assertSame(
            TestCertificate::CRT.TestCertificate::KEY.TestCertificate::CA_BUNDLE,
            $converter->asString()
        );
    }
}
