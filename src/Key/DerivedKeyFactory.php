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

use TonicForHealth\DUKPT\Helper\Encryption\DESEncryptionHelper;

/**
 * Class DerivedKeyFactory
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class DerivedKeyFactory implements KeyFactoryInterface
{
    const MODIFIED_KSN_SIZE_BYTES = 8;
    const ENCRYPTION_KEY_SIZE_BYTES = 8;

    /**
     * @var DESEncryptionHelper
     */
    protected $encryptionHelper;

    /**
     * DerivedKeyFactory constructor.
     *
     * @param DESEncryptionHelper $encryptionHelper
     */
    public function __construct(DESEncryptionHelper $encryptionHelper)
    {
        $this->encryptionHelper = $encryptionHelper;
    }

    /**
     * {@inheritdoc}
     *
     * @return DerivedKey
     */
    public function createFromHexadecimal($hexKey)
    {
        return new DerivedKey(hex2bin($hexKey));
    }

    /**
     * Returns a key from KSN and IPEK
     *
     * @param KeySerialNumber         $ksn
     * @param InitialPinEncryptionKey $ipek
     *
     * @throws \InvalidArgumentException If the provided key has a wrong size
     *
     * @return DerivedKey
     */
    public function create(KeySerialNumber $ksn, InitialPinEncryptionKey $ipek)
    {
        $binKey = $ipek->toBinary();

        $binInitKSN = $ksn->getInitialKey();
        $binModifiedKSN = substr($binInitKSN, -self::MODIFIED_KSN_SIZE_BYTES);
        $counter = hexdec(bin2hex($ksn->getEncryptionCounter()));

        for ($mask = 0x100000; $mask > 0; $mask >>= 1) {
            if (0 < ($value = $counter & $mask)) {
                $hexValue = str_pad(dechex($value), DerivedKey::KEY_SIZE_BYTES, '0', STR_PAD_LEFT);
                $binModifiedKSN |= hex2bin($hexValue);
                $binKey = $this->calculateKey($binKey, $binModifiedKSN);
            }
        }

        return new DerivedKey($binKey);
    }

    /**
     * @param string $binCurrentSK
     * @param string $binModifiedKSN
     *
     * @return string
     */
    protected function calculateKey($binCurrentSK, $binModifiedKSN)
    {
        $binEncLowerMask = hex2bin(InitialPinEncryptionKeyFactory::ENCRYPTION_LOWER_KEY_MASK);

        $binUpperBytes = $this->calculateKeyPart($binCurrentSK ^ $binEncLowerMask, $binModifiedKSN);
        $binLowerBytes = $this->calculateKeyPart($binCurrentSK, $binModifiedKSN);

        return $binUpperBytes.$binLowerBytes;
    }

    /**
     * @param string $binCurrentSK
     * @param string $binModifiedKSN
     *
     * @return string
     */
    protected function calculateKeyPart($binCurrentSK, $binModifiedKSN)
    {
        $binUpperKey = substr($binCurrentSK, 0, self::ENCRYPTION_KEY_SIZE_BYTES);
        $binLowerKey = substr($binCurrentSK, -self::ENCRYPTION_KEY_SIZE_BYTES);
        $binMessage = $binLowerKey ^ $binModifiedKSN;

        $cryptText = $this->encryptionHelper->encrypt($binUpperKey, $binMessage);

        return $cryptText ^ $binLowerKey;
    }
}
