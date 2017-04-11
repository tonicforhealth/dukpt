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

use TonicForHealth\DUKPT\Key\DerivedKey;
use TonicForHealth\DUKPT\Key\KeyInterface;

/**
 * Class DerivedKeyTest
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class DerivedKeyTest extends AbstractKeyTestCase
{
    /**
     * @test
     */
    public function shouldCreateFromHexadecimal()
    {
        $keyHexadecimal = '0123456789ABCDEFFEDCBA9876543210';
        $key = $this->createDerivedKeyFactory()->createFromHexadecimal($keyHexadecimal);

        static::assertInstanceOf(DerivedKey::class, $key);
        static::assertInstanceOf(KeyInterface::class, $key);

        static::assertEquals(hex2bin($keyHexadecimal), $key->toBinary());

        static::assertEquals($keyHexadecimal, $key->toHexadecimal());
        static::assertEquals($keyHexadecimal, (string) $key);
    }

    /**
     * @test
     * @dataProvider providerCreate
     *
     * @param string $ksnHexadecimal
     * @param string $expectedHexadecimal
     */
    public function shouldCreate($ksnHexadecimal, $expectedHexadecimal)
    {
        $ksn = $this->createKSNFactory()->createFromHexadecimal($ksnHexadecimal);
        $ipek = $this->createIPEKFactory()->createFromHexadecimal('6AC292FAA1315B4D858AB3A3D7D5933A');

        $key = $this->createDerivedKeyFactory()->create($ksn, $ipek);

        static::assertInstanceOf(DerivedKey::class, $key);
        static::assertInstanceOf(KeyInterface::class, $key);

        static::assertEquals(hex2bin($expectedHexadecimal), $key->toBinary());

        static::assertEquals($expectedHexadecimal, $key->toHexadecimal());
        static::assertEquals($expectedHexadecimal, (string) $key);
    }

    /**
     * @see shouldCreate
     *
     * @return array
     */
    public function providerCreate()
    {
        return [
            ['FFFF9876543210E00000', '6AC292FAA1315B4D858AB3A3D7D5933A'],
            ['FFFF9876543210E00003', '0DF3D9422ACA56E547676D07AD6BADFA'],
            ['FFFF9876543210E00008', '27F66D5244FF62E1AA6F6120EDEB4280'],
            ['FFFF9876543210E0000A', '6CF2500A22507C7CC776CEADC1E33014'],
        ];
    }

    /**
     * @test
     * @dataProvider providerGetPinEncryptionKey
     *
     * @param string $ksnHexadecimal
     * @param string $expectedHexadecimal
     */
    public function shouldGetPinEncryptionKey($ksnHexadecimal, $expectedHexadecimal)
    {
        $ksn = $this->createKSNFactory()->createFromHexadecimal($ksnHexadecimal);
        $ipek = $this->createIPEKFactory()->createFromHexadecimal('6AC292FAA1315B4D858AB3A3D7D5933A');

        $key = $this->createDerivedKeyFactory()->create($ksn, $ipek);

        static::assertEquals(hex2bin($expectedHexadecimal), $key->getPinEncryptionKey());
        static::assertEquals($expectedHexadecimal, $key->getPinEncryptionKeyHexadecimal());
    }

    /**
     * @see shouldGetPinEncryptionKey
     *
     * @return array
     */
    public function providerGetPinEncryptionKey()
    {
        return [
            ['FFFF9876543210E00003', '0DF3D9422ACA561A47676D07AD6BAD05'],
            ['FFFF9876543210E00007', '0C8F780B7C8B492FAE84A9EB2A6CE69F'],
            ['FFFF9876543210E0000F', '93DD5B956C4878B82E453AAEFD32A555'],
            ['FFFF9876543210E00010', '59598DCBD9BD943F94165CE453585FA8'],
            ['FFFF9876543210E00013', 'C3DF489FDF11534BF03DE97C27DC4CD0'],
            ['FFFF9876543210EFF800', 'F9CDFEBF4F5B1D61B3EC12454527E189'],
        ];
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid Derived Key size (expected 16 bytes, got 15).
     * @expectedExceptionCode 0
     */
    public function shouldThrowsShorterKeyException()
    {
        $this->createDerivedKeyFactory()->createFromHexadecimal('0123456789ABCDEFFEDCBA98765432');
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid Derived Key size (expected 16 bytes, got 17).
     * @expectedExceptionCode 0
     */
    public function shouldThrowsLongerKeyException()
    {
        $this->createDerivedKeyFactory()->createFromHexadecimal('0123456789ABCDEFFEDCBA987654321001');
    }
}
