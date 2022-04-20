<?php

namespace Exonet\CertificateConverter\tests\Formats;

use Exonet\CertificateConverter\Formats\Pem;
use Exonet\CertificateConverter\Formats\Plain;
use Exonet\CertificateConverter\tests\Inputs\TestCertificate;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class PemTest extends TestCase
{
    public function testConvertWithKey()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setKey(TestCertificate::KEY)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $pem = new Pem();
        $pem->setPlain($plain);

        $this->assertSame(
            TestCertificate::KEY.TestCertificate::CRT.TestCertificate::CA_BUNDLE,
            $pem->toString()
        );
    }

    public function testConvertNoKey()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $pem = new Pem();
        $pem->setPlain($plain);

        $this->assertSame(
            TestCertificate::CRT.TestCertificate::CA_BUNDLE,
            $pem->toString()
        );
    }

    public function testExport()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $pem = new Pem();
        $pem->setPlain($plain);
        $pem->setName('domain.io');

        $this->assertSame(
            [
                'domain.io.pem' => TestCertificate::CRT.TestCertificate::CA_BUNDLE,
            ],
            $pem->export()
        );
    }
}
