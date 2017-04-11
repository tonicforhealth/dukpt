<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Tests\Key;

use TonicForHealth\DUKPT\Key\BaseDerivationKey;
use TonicForHealth\DUKPT\Key\KeyInterface;

/**
 * Class BaseDerivationKeyTest
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class BaseDerivationKeyTest extends AbstractKeyTestCase
{
    /**
     * @test
     */
    public function shouldCreateFromHexadecimal()
    {
        $keyHexadecimal = '0123456789ABCDEFFEDCBA9876543210';
        $key = $this->createBDKFactory()->createFromHexadecimal($keyHexadecimal);

        static::assertInstanceOf(BaseDerivationKey::class, $key);
        static::assertInstanceOf(KeyInterface::class, $key);

        static::assertEquals(hex2bin($keyHexadecimal), $key->toBinary());

        static::assertEquals($keyHexadecimal, $key->toHexadecimal());
        static::assertEquals($keyHexadecimal, (string) $key);
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid BDK size (expected 16 bytes, got 15).
     * @expectedExceptionCode 0
     */
    public function shouldThrowsShorterKeyException()
    {
        $this->createBDKFactory()->createFromHexadecimal('0123456789ABCDEFFEDCBA98765432');
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid BDK size (expected 16 bytes, got 17).
     * @expectedExceptionCode 0
     */
    public function shouldThrowsLongerKeyException()
    {
        $this->createBDKFactory()->createFromHexadecimal('0123456789ABCDEFFEDCBA987654321001');
    }
}
