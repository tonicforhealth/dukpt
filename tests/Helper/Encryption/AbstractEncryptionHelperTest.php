<?php
/*
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TonicForHealth\DUKPT\Tests\Helper\Encryption;

use TonicForHealth\DUKPT\Helper\Encryption\EncryptionHelperInterface;

/**
 * Class AbstractEncryptionHelperTest
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
abstract class AbstractEncryptionHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider providerEncrypt
     *
     * @param string $key
     * @param string $data
     * @param string $cryptText
     */
    public function shouldEncrypt($key, $data, $cryptText)
    {
        $encryptionHelper = $this->getEncryptionHelper();

        static::assertEquals($cryptText, strtoupper(bin2hex($encryptionHelper->encrypt(hex2bin($key), $data))));
    }

    /**
     * @test
     * @dataProvider providerDecrypt
     *
     * @param string $key
     * @param string $data
     * @param string $plainText
     */
    public function shouldDecrypt($key, $data, $plainText)
    {
        $encryptionHelper = $this->getEncryptionHelper();

        static::assertEquals($plainText, $encryptionHelper->decrypt(hex2bin($key), hex2bin($data)));
    }

    /**
     * @return array
     *
     * @see shouldEncrypt
     */
    abstract public function providerEncrypt();

    /**
     * @return array
     *
     * @see shouldDecrypt
     */
    abstract public function providerDecrypt();

    /**
     * @return EncryptionHelperInterface
     */
    abstract protected function getEncryptionHelper();
}
