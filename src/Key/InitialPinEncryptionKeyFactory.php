<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Key;

use TonicForHealth\DUKPT\Helper\Encryption\TripleDESEncryptionHelper;

/**
 * Class InitialPinEncryptionKeyFactory
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class InitialPinEncryptionKeyFactory implements KeyFactoryInterface
{
    const ENCRYPTION_INIT_KSN_BYTES = 8;
    const ENCRYPTION_LOWER_KEY_MASK = 'C0C0C0C000000000C0C0C0C000000000';

    /**
     * @var TripleDESEncryptionHelper
     */
    protected $encryptionHelper;

    /**
     * InitialPinEncryptionKeyFactory constructor.
     *
     * @param TripleDESEncryptionHelper $encryptionHelper
     */
    public function __construct(TripleDESEncryptionHelper $encryptionHelper)
    {
        $this->encryptionHelper = $encryptionHelper;
    }

    /**
     * {@inheritdoc}
     *
     * @return InitialPinEncryptionKey
     */
    public function createFromHexadecimal($hexKey)
    {
        return new InitialPinEncryptionKey(hex2bin($hexKey));
    }

    /**
     * Returns a key from BDK and KSN
     *
     * @param BaseDerivationKey $bdk
     * @param KeySerialNumber   $ksn
     *
     * @throws \InvalidArgumentException If the provided key has a wrong size
     *
     * @return InitialPinEncryptionKey
     */
    public function create(BaseDerivationKey $bdk, KeySerialNumber $ksn)
    {
        $binBDK = $bdk->toBinary();
        $binInitKSN = $ksn->getInitialKey();
        $binInitKSNUpperBytes = substr($binInitKSN, 0, self::ENCRYPTION_INIT_KSN_BYTES);

        $binUpperKey = $binBDK;
        $binLowerKey = $binBDK ^ hex2bin(self::ENCRYPTION_LOWER_KEY_MASK);

        $binUpperBytes = $this->encryptionHelper->encrypt($binUpperKey, $binInitKSNUpperBytes);
        $binLowerBytes = $this->encryptionHelper->encrypt($binLowerKey, $binInitKSNUpperBytes);

        $binKey = $binUpperBytes.$binLowerBytes;

        return new InitialPinEncryptionKey($binKey);
    }
}
