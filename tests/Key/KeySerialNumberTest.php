<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Tests\Key;

use TonicForHealth\DUKPT\Key\KeyInterface;
use TonicForHealth\DUKPT\Key\KeySerialNumber;

/**
 * Class KeySerialNumberTest
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class KeySerialNumberTest extends AbstractKeyTestCase
{
    /**
     * @test
     * @dataProvider providerCreateFromHexadecimal
     *
     * @param string $expectedKeyHexadecimal
     * @param string $keyHexadecimal
     */
    public function shouldCreateFromHexadecimal($expectedKeyHexadecimal, $keyHexadecimal)
    {
        $key = $this->createKSNFactory()->createFromHexadecimal($keyHexadecimal);

        static::assertInstanceOf(KeySerialNumber::class, $key);
        static::assertInstanceOf(KeyInterface::class, $key);

        static::assertEquals(hex2bin($expectedKeyHexadecimal), $key->toBinary());

        static::assertEquals($expectedKeyHexadecimal, $key->toHexadecimal());
        static::assertEquals($expectedKeyHexadecimal, (string) $key);
    }

    /**
     * @see shouldCreateFromHexadecimal
     *
     * @return array
     */
    public function providerCreateFromHexadecimal()
    {
        return [
            ['FFFF9876543210E00008', 'FFFF9876543210E00008'],
            ['FFFF9876543210E00008', '9876543210E00008'],
        ];
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid KSN size (expected from 3 to 10 bytes, got 2).
     * @expectedExceptionCode 0
     */
    public function shouldThrowsShorterKeyException()
    {
        $this->createKSNFactory()->createFromHexadecimal('0008');
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid KSN size (expected from 3 to 10 bytes, got 11).
     * @expectedExceptionCode 0
     */
    public function shouldThrowsLongerKeyException()
    {
        $this->createKSNFactory()->createFromHexadecimal('FFFFFF9876543210E00008');
    }

    /**
     * @test
     * @dataProvider providerGetInitialKey
     *
     * @param string $expectedKeyHexadecimal
     * @param string $keyHexadecimal
     */
    public function shouldGetInitialKey($expectedKeyHexadecimal, $keyHexadecimal)
    {
        $key = $this->createKSNFactory()->createFromHexadecimal($keyHexadecimal);

        static::assertEquals(hex2bin($expectedKeyHexadecimal), $key->getInitialKey());
    }

    /**
     * @see shouldGetInitialKey
     *
     * @return array
     */
    public function providerGetInitialKey()
    {
        return [
            ['0123456789ABCDE00000', '0123456789ABCDEF0123'],
            ['123456789ABCDEE00000', '123456789ABCDEF01234'],
            ['23456789ABCDEF000000', '23456789ABCDEF012345'],
        ];
    }

    /**
     * @test
     * @dataProvider providerGetEncryptionCounter
     *
     * @param string $expectedKeyHexadecimal
     * @param string $keyHexadecimal
     */
    public function shouldGetEncryptionCounter($expectedKeyHexadecimal, $keyHexadecimal)
    {
        $key = $this->createKSNFactory()->createFromHexadecimal($keyHexadecimal);

        static::assertEquals(hex2bin($expectedKeyHexadecimal), $key->getEncryptionCounter());
    }

    /**
     * @see shouldGetEncryptionCounter
     *
     * @return array
     */
    public function providerGetEncryptionCounter()
    {
        return [
            ['0F0123', '0123456789ABCDEF0123'],
            ['101234', '123456789ABCDEF01234'],
            ['012345', '23456789ABCDEF012345'],
        ];
    }
}
