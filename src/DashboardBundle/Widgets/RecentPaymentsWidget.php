<?php

declare(strict_types=1);

/*
 * This file is part of CSBill project.
 *
 * (c) 2013-2017 Pierre du Plessis <info@customscripts.co.za>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CSBill\DashboardBundle\Widgets;

use CSBill\PaymentBundle\Repository\PaymentRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RecentPaymentsWidget implements WidgetInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $manager;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->manager = $registry->getManager();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        /** @var PaymentRepository $paymentRepository */
        $paymentRepository = $this->manager->getRepository('CSBillPaymentBundle:Payment');

        $payments = $paymentRepository->getRecentPayments();

        return ['payments' => $payments];
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return 'CSBillDashboardBundle:Widget:recent_payments.html.twig';
    }
}
