<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT;

use TonicForHealth\DUKPT\Helper\Encryption\DESEncryptionHelper;
use TonicForHealth\DUKPT\Helper\Encryption\TripleDESEncryptionHelper;
use TonicForHealth\DUKPT\Key\BaseDerivationKeyFactory;
use TonicForHealth\DUKPT\Key\DerivedKeyFactory;
use TonicForHealth\DUKPT\Key\InitialPinEncryptionKeyFactory;
use TonicForHealth\DUKPT\Key\KeySerialNumberFactory;

/**
 * Class DUKPTFactory
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class DUKPTFactory
{
    /**
     * @return BaseDerivationKeyFactory
     */
    public function createBDKFactory()
    {
        return new BaseDerivationKeyFactory();
    }

    /**
     * @return KeySerialNumberFactory
     */
    public function createKSNFactory()
    {
        return new KeySerialNumberFactory();
    }

    /**
     * @return InitialPinEncryptionKeyFactory
     */
    public function createIPEKFactory()
    {
        return new InitialPinEncryptionKeyFactory(new TripleDESEncryptionHelper());
    }

    /**
     * @return DerivedKeyFactory
     */
    public function createDerivedKeyFactory()
    {
        return new DerivedKeyFactory(new DESEncryptionHelper());
    }
}
