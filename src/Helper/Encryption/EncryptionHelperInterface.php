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
 * Interface EncryptionHelperInterface
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
interface EncryptionHelperInterface
{
    /**
     * Encrypts a plaintext with the given key.
     *
     * @param string $key  The key with which the data will be encrypted.
     * @param string $data The data that will be encrypted. If the size of the data is not n * blocksize,
     *                     the data will be padded with '\0'.
     *
     * @return string The encrypted data as a string or FALSE on failure.
     *
     * @see openssl_encrypt
     */
    public function encrypt($key, $data);

    /**
     * Decrypts a crypttext with the given key.
     *
     * @param string $key  The key with which the data was encrypted.
     * @param string $data The data that will be decrypted. If the size of the data is not n * blocksize,
     *                     the data will be padded with '\0'.
     *
     * @return string The decrypted data as a string or FALSE on failure.
     *
     * @see openssl_decrypt
     */
    public function decrypt($key, $data);
}
