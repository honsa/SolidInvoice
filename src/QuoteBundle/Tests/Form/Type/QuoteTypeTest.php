<?php

declare(strict_types=1);

/*
 * This file is part of SolidInvoice project.
 *
 * (c) 2013-2017 Pierre du Plessis <info@customscripts.co.za>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SolidInvoice\QuoteBundle\Tests\Form\Type;

use SolidInvoice\CoreBundle\Form\Type\DiscountType;
use SolidInvoice\CoreBundle\Tests\FormTestCase;
use SolidInvoice\MoneyBundle\Entity\Money;
use SolidInvoice\QuoteBundle\Entity\Quote;
use SolidInvoice\QuoteBundle\Form\Type\ItemType;
use SolidInvoice\QuoteBundle\Form\Type\QuoteType;
use Money\Currency;
use Symfony\Component\Form\PreloadedExtension;

class QuoteTypeTest extends FormTestCase
{
    public function testSubmit()
    {
        $formData = [
            'client' => null,
            'discount' => 12,
            'items' => [],
            'terms' => '',
            'notes' => '',
            'total' => 0,
            'baseTotal' => 0,
            'tax' => 123,
        ];

        Money::setBaseCurrency('USD');

        $object = new Quote();

        $this->assertFormData($this->factory->create(QuoteType::class, $object), $formData, $object);
    }

    protected function getExtensions()
    {
        $type = new QuoteType(new Currency('USD'));
        $itemType = new ItemType($this->registry);

        return [
            new PreloadedExtension([$type, $itemType, new DiscountType(new Currency('USD'))], []),
        ];
    }
}
