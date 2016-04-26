<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Tests\Helper\Encryption;

use TonicForHealth\DUKPT\Helper\Encryption\DESEncryptionHelper;

/**
 * Class DESEncryptionHelperTest
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class DESEncryptionHelperTest extends AbstractEncryptionHelperTest
{
    /**
     * {@inheritdoc}
     */
    public function providerEncrypt()
    {
        return [
            ['0123456789ABCDEF', 'TEST/TESTCARD', '7E2B8636A1A029A0204B839D29CF8E38'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function providerDecrypt()
    {
        return [
            ['0123456789ABCDEF', '7E2B8636A1A029A0204B839D29CF8E38', 'TEST/TESTCARD'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getEncryptionHelper()
    {
        return new DESEncryptionHelper();
    }
}
