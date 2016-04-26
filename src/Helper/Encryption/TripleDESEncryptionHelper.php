<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Helper\Encryption;

/**
 * Class TripleDESEncryptionHelper
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class TripleDESEncryptionHelper extends AbstractEncryptionHelper
{
    const ENCRYPTION_KEY_SIZE_BYTES = 24;

    /**
     * {@inheritdoc}
     */
    public function encrypt($key, $data)
    {
        return parent::encrypt($this->padKey($key), $data);
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($key, $data)
    {
        return parent::decrypt($this->padKey($key), $data);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function padKey($key)
    {
        if (static::ENCRYPTION_KEY_SIZE_BYTES > strlen($key)) {
            $key = str_pad($key, static::ENCRYPTION_KEY_SIZE_BYTES, $key);
        }

        return $key;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCipher()
    {
        return MCRYPT_3DES;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMode()
    {
        return MCRYPT_MODE_CBC;
    }
}
