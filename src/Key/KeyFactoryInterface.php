<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Key;

/**
 * Interface KeyFactoryInterface
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
interface KeyFactoryInterface
{
    /**
     * Returns a key from its hexadecimal representation
     *
     * @param string $hexKey The hexadecimal representation of a key
     *
     * @throws \InvalidArgumentException If the provided key has a wrong size
     *
     * @return KeyInterface
     */
    public function createFromHexadecimal($hexKey);
}
