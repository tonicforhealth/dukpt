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
 * Class AbstractEncryptionHelper
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
abstract class AbstractEncryptionHelper implements EncryptionHelperInterface
{
    const NULL_CHAR = "\0";

    /**
     * {@inheritdoc}
     */
    public function encrypt($key, $data)
    {
        return openssl_encrypt($data, $this->getCipherMethod(), $key, OPENSSL_RAW_DATA, $this->getIV());
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($key, $data)
    {
        return rtrim(openssl_decrypt($data, $this->getCipherMethod(), $key, $this->getEncodingOptions(), $this->getIV()), self::NULL_CHAR);
    }

    /**
     * Returns the IV belonging to a specific cipher/mode combination
     *
     * @return string
     */
    protected function getIV()
    {
        return str_repeat(self::NULL_CHAR, openssl_cipher_iv_length($this->getCipherMethod()));
    }

    /**
     * Returns one of the available cipher methods
     * @see openssl_get_cipher_methods()
     *
     * @return string
     */
    abstract protected function getCipherMethod();

    /**
     * @see openssl_decrypt() and openssl_encrypt() parameters
     *
     * @return int
     */
    abstract protected function getEncodingOptions();
}
