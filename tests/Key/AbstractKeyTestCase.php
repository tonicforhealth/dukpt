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

use TonicForHealth\DUKPT\Helper\Encryption\DESEncryptionHelper;
use TonicForHealth\DUKPT\Helper\Encryption\TripleDESEncryptionHelper;
use TonicForHealth\DUKPT\Key\BaseDerivationKeyFactory;
use TonicForHealth\DUKPT\Key\DerivedKeyFactory;
use TonicForHealth\DUKPT\Key\InitialPinEncryptionKeyFactory;
use TonicForHealth\DUKPT\Key\KeySerialNumberFactory;

/**
 * Class AbstractKeyTestCase
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
abstract class AbstractKeyTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return BaseDerivationKeyFactory
     */
    protected function createBDKFactory()
    {
        return new BaseDerivationKeyFactory();
    }

    /**
     * @return KeySerialNumberFactory
     */
    protected function createKSNFactory()
    {
        return new KeySerialNumberFactory();
    }

    /**
     * @return InitialPinEncryptionKeyFactory
     */
    protected function createIPEKFactory()
    {
        return new InitialPinEncryptionKeyFactory(new TripleDESEncryptionHelper());
    }

    /**
     * @return DerivedKeyFactory
     */
    protected function createDerivedKeyFactory()
    {
        return new DerivedKeyFactory(new DESEncryptionHelper());
    }
}
