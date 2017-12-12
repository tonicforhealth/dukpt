<?php
/*
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TonicForHealth\DUKPT\Key;

/**
 * Class KeySerialNumber
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class KeySerialNumber extends AbstractKey
{
    const KEY_SIZE_BYTES = 10;
    const KEY_COUNTER_BYTES = 3;
    const KEY_INITIAL_MASK = 'FFFFFFFFFFFFFFE00000';

    /**
     * Returns the Initial Key Serial Number as a binary data string
     *
     * @return string
     */
    public function getInitialKey()
    {
        return $this->toBinary() & hex2bin(self::KEY_INITIAL_MASK);
    }

    /**
     * Returns a value for the Encryption Counter as a binary data string
     *
     * @return string
     */
    public function getEncryptionCounter()
    {
        return substr($this->toBinary() & ~hex2bin(self::KEY_INITIAL_MASK), -self::KEY_COUNTER_BYTES);
    }

    /**
     * {@inheritdoc}
     */
    protected function validateKey($binKey)
    {
        $keySize = strlen($binKey);

        if (self::KEY_COUNTER_BYTES > $keySize || self::KEY_SIZE_BYTES < $keySize) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid KSN size (expected from %d to %d bytes, got %d).',
                    self::KEY_COUNTER_BYTES,
                    self::KEY_SIZE_BYTES,
                    $keySize
                )
            );
        }

        return $this->padKey($binKey);
    }

    /**
     * @param string $binKey
     *
     * @return string
     */
    protected function padKey($binKey)
    {
        if (self::KEY_SIZE_BYTES > strlen($binKey)) {
            $binKey = str_pad($binKey, self::KEY_SIZE_BYTES, hex2bin('FF'), STR_PAD_LEFT);
        }

        return $binKey;
    }
}
