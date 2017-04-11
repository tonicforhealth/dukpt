<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Key;

/**
 * Interface KeyInterface
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
interface KeyInterface
{
    /**
     * Returns the key as a binary data string
     *
     * @return string
     */
    public function toBinary();

    /**
     * Returns the hexadecimal representation of the key
     *
     * @return string
     */
    public function toHexadecimal();

    /**
     * @return string
     */
    public function __toString();
}
