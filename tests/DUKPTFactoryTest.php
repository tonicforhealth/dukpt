<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016-2017 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Tests;

use TonicForHealth\DUKPT\DUKPTFactory;
use TonicForHealth\DUKPT\Key\BaseDerivationKeyFactory;
use TonicForHealth\DUKPT\Key\DerivedKeyFactory;
use TonicForHealth\DUKPT\Key\InitialPinEncryptionKeyFactory;
use TonicForHealth\DUKPT\Key\KeyFactoryInterface;
use TonicForHealth\DUKPT\Key\KeySerialNumberFactory;

/**
 * Class DUKPTFactoryTest
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class DUKPTFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DUKPTFactory
     */
    protected $factory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->factory = new DUKPTFactory();
    }

    /**
     * @test
     */
    public function shouldCreateBDKFactory()
    {
        $factory = $this->factory->createBDKFactory();

        static::assertInstanceOf(BaseDerivationKeyFactory::class, $factory);
        static::assertInstanceOf(KeyFactoryInterface::class, $factory);
    }

    /**
     * @test
     */
    public function shouldCreateKSNFactory()
    {
        $factory = $this->factory->createKSNFactory();

        static::assertInstanceOf(KeySerialNumberFactory::class, $factory);
        static::assertInstanceOf(KeyFactoryInterface::class, $factory);
    }

    /**
     * @test
     */
    public function shouldCreateIPEKFactory()
    {
        $factory = $this->factory->createIPEKFactory();

        static::assertInstanceOf(InitialPinEncryptionKeyFactory::class, $factory);
        static::assertInstanceOf(KeyFactoryInterface::class, $factory);
    }

    /**
     * @test
     */
    public function shouldCreateDerivedKeyFactory()
    {
        $factory = $this->factory->createDerivedKeyFactory();

        static::assertInstanceOf(DerivedKeyFactory::class, $factory);
        static::assertInstanceOf(KeyFactoryInterface::class, $factory);
    }
}
