<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Device;

use TonicForHealth\DUKPT\DUKPTFactory;
use TonicForHealth\DUKPT\Helper\Encryption\EncryptionHelperInterface;
use TonicForHealth\DUKPT\Key\BaseDerivationKeyFactory;
use TonicForHealth\DUKPT\Key\DerivedKey;
use TonicForHealth\DUKPT\Key\DerivedKeyFactory;
use TonicForHealth\DUKPT\Key\InitialPinEncryptionKeyFactory;
use TonicForHealth\DUKPT\Key\KeySerialNumberFactory;

/**
 * Class AbstractDevice
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
abstract class AbstractDevice implements DeviceInterface
{
    /**
     * @var BaseDerivationKeyFactory
     */
    protected $bdkFactory;

    /**
     * @var KeySerialNumberFactory
     */
    protected $ksnFactory;

    /**
     * @var InitialPinEncryptionKeyFactory
     */
    protected $ipekFactory;

    /**
     * @var DerivedKeyFactory
     */
    protected $derivedKeyFactory;

    /**
     * @var EncryptionHelperInterface
     */
    protected $encryptionHelper;

    /**
     * @var string
     */
    protected $sessionKey;

    /**
     * {@inheritdoc}
     */
    public function __construct(DUKPTFactory $factory)
    {
        $this->bdkFactory = $factory->createBDKFactory();
        $this->ksnFactory = $factory->createKSNFactory();
        $this->ipekFactory = $factory->createIPEKFactory();
        $this->derivedKeyFactory = $factory->createDerivedKeyFactory();

        $this->encryptionHelper = $this->createEncryptionHelper();
    }

    /**
     * {@inheritdoc}
     */
    public function load($hexBDK, $hexKSN)
    {
        $bdk = $this->bdkFactory->createFromHexadecimal($hexBDK);
        $ksn = $this->ksnFactory->createFromHexadecimal($hexKSN);
        $ipek = $this->ipekFactory->create($bdk, $ksn);

        $derivedKey = $this->derivedKeyFactory->create($ksn, $ipek);
        $this->sessionKey = $this->createSessionKey($derivedKey);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionKey()
    {
        return $this->sessionKey;
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($cipherText)
    {
        return $this->encryptionHelper->decrypt($this->sessionKey, hex2bin($cipherText));
    }

    /**
     * @return EncryptionHelperInterface
     */
    abstract protected function createEncryptionHelper();

    /**
     * @param DerivedKey $derivedKey
     *
     * @return string
     */
    abstract protected function createSessionKey(DerivedKey $derivedKey);
}
