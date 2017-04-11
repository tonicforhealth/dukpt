<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Device;

use TonicForHealth\DUKPT\DUKPTFactory;

/**
 * Interface DeviceInterface
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
interface DeviceInterface
{
    /**
     * DeviceInterface constructor.
     *
     * @param DUKPTFactory $factory
     */
    public function __construct(DUKPTFactory $factory);

    /**
     * Initiates the device with specified base keys.
     *
     * @param string $hexBDK The hexadecimal representation of the Base Derivation Key
     * @param string $hexKSN The hexadecimal representation of the Key Serial Number
     *
     * @throws \InvalidArgumentException If the provided key has a wrong size
     *
     * @return $this
     */
    public function load($hexBDK, $hexKSN);

    /**
     * Returns an encryption key for the current session.
     *
     * @return string
     */
    public function getSessionKey();

    /**
     * Decrypts a ciphertext with pre-loaded encryption keys.
     *
     * @param string $cipherText The hexadecimal representation of the ciphertext
     *
     * @return string
     *
     * @see load
     */
    public function decrypt($cipherText);
}
