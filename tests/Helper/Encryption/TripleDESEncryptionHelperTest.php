<?php
/**
 * This file is part of the DUKPT package.
 *
 * Copyright (c) 2016 Tonic Health <info@tonicforhealth.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace TonicForHealth\DUKPT\Tests\Helper\Encryption;

use TonicForHealth\DUKPT\Helper\Encryption\TripleDESEncryptionHelper;

/**
 * Class TripleDESEncryptionHelperTest
 *
 * @author Vitalii Ekert <vitalii.ekert@tonicforhealth.com>
 */
class TripleDESEncryptionHelperTest extends AbstractEncryptionHelperTest
{
    /**
     * {@inheritdoc}
     */
    public function providerEncrypt()
    {
        return [
            ['0123456789ABCDEF', 'TEST/TESTCARD', '7E2B8636A1A029A0204B839D29CF8E38'],
            ['0123456789ABCDEFFEDCBA9876543210', 'TEST/TESTCARD', 'F0A2080F8E28AE36A55A3128F597EF8A'],
            ['0123456789ABCDEFFEDCBA98765432100123456789ABCDEF', 'TEST/TESTCARD', 'F0A2080F8E28AE36A55A3128F597EF8A'],
            ['0123456789ABCDEFFEDCBA9876543210FEDCBA9876543210', 'TEST/TESTCARD', '7E2B8636A1A029A0204B839D29CF8E38'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function providerDecrypt()
    {
        return [
            ['0123456789ABCDEF', '7E2B8636A1A029A0204B839D29CF8E38', 'TEST/TESTCARD'],
            ['0123456789ABCDEFFEDCBA9876543210', 'F0A2080F8E28AE36A55A3128F597EF8A', 'TEST/TESTCARD'],
            ['0123456789ABCDEFFEDCBA98765432100123456789ABCDEF', 'F0A2080F8E28AE36A55A3128F597EF8A', 'TEST/TESTCARD'],
            ['0123456789ABCDEFFEDCBA9876543210FEDCBA9876543210', '7E2B8636A1A029A0204B839D29CF8E38', 'TEST/TESTCARD'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getEncryptionHelper()
    {
        return new TripleDESEncryptionHelper();
    }
}
