<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Device;

use TonicForHealth\DUKPT\Helper\Encryption\TripleDESEncryptionHelper;
use TonicForHealth\DUKPT\Key\DerivedKey;

/**
 * Class PinEncryptionDevice
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class PinEncryptionDevice extends AbstractDevice
{
    /**
     * {@inheritdoc}
     */
    protected function createEncryptionHelper()
    {
        return new TripleDESEncryptionHelper();
    }

    /**
     * {@inheritdoc}
     */
    protected function createSessionKey(DerivedKey $derivedKey)
    {
        return $derivedKey->getPinEncryptionKey();
    }
}
