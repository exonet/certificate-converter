<?php

namespace Exonet\CertificateConverter\tests\Formats;

use Exonet\CertificateConverter\Formats\Plain;
use Exonet\CertificateConverter\tests\Inputs\TestCertificate;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class PlainTest extends TestCase
{
    public function testStringWithKey()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setKey(TestCertificate::KEY)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $this->assertSame(
            TestCertificate::CRT.TestCertificate::KEY.TestCertificate::CA_BUNDLE,
            $plain->toString()
        );
    }

    public function testStringNoKey()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $this->assertSame(
            TestCertificate::CRT.TestCertificate::CA_BUNDLE,
            $plain->toString()
        );
    }

    public function testExport()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setKey(TestCertificate::KEY)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $this->assertSame(
            [
                'certificate.key' => TestCertificate::KEY,
                'certificate.crt' => TestCertificate::CRT,
                'certificate.ca-bundle' => TestCertificate::CA_BUNDLE,
            ],
            $plain->export()
        );
    }
}
