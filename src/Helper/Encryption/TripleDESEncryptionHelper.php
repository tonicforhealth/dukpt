<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
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
        return str_pad($key, self::ENCRYPTION_KEY_SIZE_BYTES, $key);
    }

    /**
     * {@inheritdoc}
     */
    protected function getCipherMethod()
    {
        return 'des-ede3-cbc';
    }
}
