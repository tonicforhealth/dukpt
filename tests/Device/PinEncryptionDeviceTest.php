<?php
/*
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TonicForHealth\DUKPT\Tests\Device;

use TonicForHealth\DUKPT\Device\PinEncryptionDevice;
use TonicForHealth\DUKPT\DUKPTFactory;

/**
 * Class PinEncryptionDeviceTest
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class PinEncryptionDeviceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @return PinEncryptionDevice
     */
    public function shouldLoad()
    {
        $device = new PinEncryptionDevice(new DUKPTFactory());
        $device->load('0123456789ABCDEFFEDCBA9876543210', 'FFFF9876543210E00008');

        static::assertEquals('27F66D5244FF621EAA6F6120EDEB427F', strtoupper(bin2hex($device->getSessionKey())));

        return $device;
    }

    /**
     * @test
     * @depends shouldLoad
     *
     * @param PinEncryptionDevice $device
     */
    public function shouldDecrypt(PinEncryptionDevice $device)
    {
        $plainText = '%B4124939999999990^TEST/TESTCARD^19129015432139614567891234567890?';
        $cipherText = '160954FE1071D30C5CF260C5AC48EB5FBEFE37B32033E3B7EF693F8C6AB1BBD6276446FB3689728B926D923CD9ECCD522B6DE5850FD9AB2D7976D943C12CDC947E023098CAAE4F6D';

        static::assertEquals($plainText, $device->decrypt($cipherText));
    }

    /**
     * @test
     * @depends shouldLoad
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Hexadecimal input string must have an even length.
     *
     * @param PinEncryptionDevice $device
     */
    public function shouldThrowInvalidArgumentException(PinEncryptionDevice $device)
    {
        $device->decrypt('F');
    }
}
