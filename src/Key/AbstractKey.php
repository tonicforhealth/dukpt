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
 * Class AbstractKey
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
abstract class AbstractKey implements KeyInterface
{
    /**
     * The key as a binary data string
     *
     * @var string
     */
    private $binKey;

    /**
     * AbstractKey constructor.
     *
     * @param string $binKey The key as a binary data string
     *
     * @throws \InvalidArgumentException If the provided key has a wrong size
     */
    public function __construct($binKey)
    {
        $this->binKey = $this->validateKey($binKey);
    }

    /**
     * {@inheritdoc}
     */
    public function toBinary()
    {
        return $this->binKey;
    }

    /**
     * {@inheritdoc}
     */
    public function toHexadecimal()
    {
        return strtoupper(bin2hex($this->toBinary()));
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toHexadecimal();
    }

    /**
     * Validate the specified key
     *
     * @param string $binKey The specified key as a binary data string
     *
     * @throws \InvalidArgumentException If the provided key has a wrong size
     *
     * @return string Returns the validated key as a binary data string
     */
    abstract protected function validateKey($binKey);
}
