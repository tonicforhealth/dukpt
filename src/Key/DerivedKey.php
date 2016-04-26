<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Key;

/**
 * Class DerivedKey
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class DerivedKey extends AbstractKey
{
    const KEY_SIZE_BYTES = 16;
    const KEY_PIN_ENCRYPTION_MASK = '00000000000000FF00000000000000FF';

    /**
     * Returns the PIN Encryption Key as a binary data string
     *
     * @return string
     */
    public function getPinEncryptionKey()
    {
        return $this->toBinary() ^ hex2bin(self::KEY_PIN_ENCRYPTION_MASK);
    }

    /**
     * Returns the hexadecimal representation of the PIN Encryption Key
     *
     * @return string
     */
    public function getPinEncryptionKeyHexadecimal()
    {
        return strtoupper(bin2hex($this->getPinEncryptionKey()));
    }

    /**
     * {@inheritdoc}
     */
    protected function validateKey($binKey)
    {
        if (self::KEY_SIZE_BYTES !== ($keySize = strlen($binKey))) {
            throw new \InvalidArgumentException(
                sprintf('Invalid Derived Key size (expected %d bytes, got %d).', self::KEY_SIZE_BYTES, $keySize)
            );
        }

        return $binKey;
    }
}
