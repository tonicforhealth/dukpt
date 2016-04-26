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
 * Class BaseDerivationKeyFactory
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class BaseDerivationKeyFactory implements KeyFactoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @return BaseDerivationKey
     */
    public function createFromHexadecimal($hexKey)
    {
        return new BaseDerivationKey(hex2bin($hexKey));
    }
}
