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
 * Class BaseDerivationKey
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class BaseDerivationKey extends AbstractKey
{
    const KEY_SIZE_BYTES = 16;

    /**
     * {@inheritdoc}
     */
    protected function validateKey($binKey)
    {
        if (self::KEY_SIZE_BYTES !== ($keySize = strlen($binKey))) {
            throw new \InvalidArgumentException(
                sprintf('Invalid BDK size (expected %d bytes, got %d).', self::KEY_SIZE_BYTES, $keySize)
            );
        }

        return $binKey;
    }
}
