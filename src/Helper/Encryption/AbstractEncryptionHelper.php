<?php
/*
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
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
    const BLOCK_SIZE_BYTES = 8;
    const NULL_CHAR = "\0";

    /**
     * {@inheritdoc}
     */
    public function encrypt($key, $data)
    {
        return openssl_encrypt($this->getPaddedData($data), $this->getCipherMethod(), $key, $this->getOptions(), $this->getIV());
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($key, $data)
    {
        return rtrim(openssl_decrypt($data, $this->getCipherMethod(), $key, $this->getOptions(), $this->getIV()), self::NULL_CHAR);
    }

    /**
     * Returns one of the available cipher methods
     *
     * @see openssl_get_cipher_methods()
     *
     * @return string
     */
    abstract protected function getCipherMethod();

    /**
     * @param string $data
     *
     * @return string
     */
    private function getPaddedData($data)
    {
        $length = strlen($data);
        $offset = $length % self::BLOCK_SIZE_BYTES;

        return (0 === $offset) ? $data : str_pad($data, $length + self::BLOCK_SIZE_BYTES - $offset, self::NULL_CHAR);
    }

    /**
     * @return int
     */
    private function getOptions()
    {
        return OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING;
    }

    /**
     * Returns the IV belonging to a specific cipher/mode combination
     *
     * @return string
     */
    private function getIV()
    {
        return str_repeat(self::NULL_CHAR, openssl_cipher_iv_length($this->getCipherMethod()));
    }
}
