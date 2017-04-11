<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Tests\Key;

use TonicForHealth\DUKPT\Key\InitialPinEncryptionKey;
use TonicForHealth\DUKPT\Key\KeyInterface;

/**
 * Class InitialPinEncryptionKeyTest
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class InitialPinEncryptionKeyTest extends AbstractKeyTestCase
{
    /**
     * @test
     */
    public function shouldCreateFromHexadecimal()
    {
        $keyHexadecimal = '0123456789ABCDEFFEDCBA9876543210';
        $key = $this->createIPEKFactory()->createFromHexadecimal($keyHexadecimal);

        static::assertInstanceOf(InitialPinEncryptionKey::class, $key);
        static::assertInstanceOf(KeyInterface::class, $key);

        static::assertEquals(hex2bin($keyHexadecimal), $key->toBinary());

        static::assertEquals($keyHexadecimal, $key->toHexadecimal());
        static::assertEquals($keyHexadecimal, (string) $key);
    }

    /**
     * @test
     */
    public function shouldCreate()
    {
        $bdk = $this->createBDKFactory()->createFromHexadecimal('0123456789ABCDEFFEDCBA9876543210');
        $ksn = $this->createKSNFactory()->createFromHexadecimal('FFFF9876543210E00008');

        $key = $this->createIPEKFactory()->create($bdk, $ksn);
        $expectedHexadecimal = '6AC292FAA1315B4D858AB3A3D7D5933A';

        static::assertInstanceOf(InitialPinEncryptionKey::class, $key);
        static::assertInstanceOf(KeyInterface::class, $key);

        static::assertEquals(hex2bin($expectedHexadecimal), $key->toBinary());

        static::assertEquals($expectedHexadecimal, $key->toHexadecimal());
        static::assertEquals($expectedHexadecimal, (string) $key);
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid IPEK size (expected 16 bytes, got 15).
     * @expectedExceptionCode 0
     */
    public function shouldThrowsShorterKeyException()
    {
        $this->createIPEKFactory()->createFromHexadecimal('0123456789ABCDEFFEDCBA98765432');
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid IPEK size (expected 16 bytes, got 17).
     * @expectedExceptionCode 0
     */
    public function shouldThrowsLongerKeyException()
    {
        $this->createIPEKFactory()->createFromHexadecimal('0123456789ABCDEFFEDCBA987654321001');
    }
}
