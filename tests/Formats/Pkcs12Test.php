<?php

namespace Exonet\CertificateConverter\tests\Formats;

use Exonet\CertificateConverter\Formats\Pkcs12;
use Exonet\CertificateConverter\Formats\Plain;
use Exonet\CertificateConverter\tests\Inputs\TestCertificate;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class Pkcs12Test extends TestCase
{
    public function testConvertWithKey()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setKey(TestCertificate::KEY)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $pkcs12 = new Pkcs12(['password' => 'test-pwd']);
        $pkcs12->setPlain($plain);

        // Try to read the pkcs12.
        $this->assertTrue(
            openssl_pkcs12_read($pkcs12->toString(), $certificates, 'test-pwd')
        );

        // Assert the key and cert are in the pkcs12.
        $this->assertSame(TestCertificate::CRT, $certificates['cert']);
        $this->assertSame(TestCertificate::KEY, $certificates['pkey']);
    }

    public function testExport()
    {
        $plain = (new Plain())
            ->setCrt(TestCertificate::CRT)
            ->setKey(TestCertificate::KEY)
            ->setCaBundle(TestCertificate::CA_BUNDLE);

        $pkcs12 = new Pkcs12(['password' => 'test-pwd']);
        $pkcs12->setPlain($plain);
        $pkcs12->setName('domain.io');

        $this->assertSame(['domain.io.pfx'], array_keys($pkcs12->export()));

        // Try to read the pkcs12.
        $this->assertTrue(
            openssl_pkcs12_read($pkcs12->export()['domain.io.pfx'], $certificates, 'test-pwd')
        );

        // Assert the key and cert are in the pkcs12.
        $this->assertSame(TestCertificate::CRT, $certificates['cert']);
        $this->assertSame(TestCertificate::KEY, $certificates['pkey']);
    }
}
