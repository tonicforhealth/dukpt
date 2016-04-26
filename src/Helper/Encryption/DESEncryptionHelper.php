<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Helper\Encryption;

/**
 * Class DESEncryptionHelper
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class DESEncryptionHelper extends AbstractEncryptionHelper
{
    /**
     * {@inheritdoc}
     */
    protected function getCipher()
    {
        return MCRYPT_DES;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMode()
    {
        return MCRYPT_MODE_CBC;
    }
}
