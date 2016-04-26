<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Helper\Encryption;

/**
 * Class AbstractEncryptionHelper
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
abstract class AbstractEncryptionHelper implements EncryptionHelperInterface
{
    const NULL_CHAR = "\0";

    /**
     * {@inheritdoc}
     */
    public function encrypt($key, $data)
    {
        return mcrypt_encrypt($this->getCipher(), $key, $data, $this->getMode(), $this->getIV());
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($key, $data)
    {
        return rtrim(mcrypt_decrypt($this->getCipher(), $key, $data, $this->getMode(), $this->getIV()), self::NULL_CHAR);
    }

    /**
     * Returns the IV belonging to a specific cipher/mode combination
     *
     * @return string
     */
    protected function getIV()
    {
        return str_repeat(self::NULL_CHAR, mcrypt_get_iv_size($this->getCipher(), $this->getMode()));
    }

    /**
     * Returns one of the MCRYPT_ciphername constants of the name of the algorithm as string.
     *
     * @return string
     */
    abstract protected function getCipher();

    /**
     * Returns one of the MCRYPT_MODE_modename constants of one of "ecb", "cbc", "cfb", "ofb", "nofb" or "stream".
     *
     * @return string
     */
    abstract protected function getMode();
}
