<?php


class DashboardControllerAdmin {

    static function getStats() {
        RestControllerAdmin::create()->run(function ($_req) {
            $type = isset($_req['t']) ? $_req['t'] : 'day';

            if (!isset($_req['start'])) {
                switch ($type) {
                    case 'year';
                        $start = (new DateTime())->modify('-4 years');
                        $period = 'P1Y';
                        $addedOneUnitDate = '+1 year';
                        break;
                    case 'month';
                        $start = (new DateTime())->modify('-11 months');
                        $period = 'P1M';
                        $addedOneUnitDate = '+1 month';
                        break;
                    case 'day':
                    default:
                        $start = (new DateTime())->modify('-29 days');
                        $period = 'P1D';
                        $addedOneUnitDate = '+1 day';
                        break;
                }
            } else {
                $start = (new DateTime($_req['start']));
            }

            $end = isset($_req['end']) ? (new DateTime($_req['end'])) : (new DateTime());

            switch ($_req['q']) {
                case 'label':
                    $dates = new DatePeriod(
                        $start,
                        new DateInterval($period),
                        $end->modify($addedOneUnitDate)
                    );
                    $res = [];
                    foreach ($dates as $date) {
                        $res[] = $date->format('Y-m-d');
                    }
                    break;
                case 'order':

                    $order = StatisticService::totalOrdersFinalPrice($start, $end, $type);
                    $res = array_map(function ($var) {
                        return $var['sum'];
                    }, $order);
                    break;
                case 'payment':

                    $payment = StatisticService::totalSitePayments($start, $end, $type, 1, '1,2');
                    $res = array_map(function ($var) {
                        return $var['sum'];
                    }, $payment);

                    break;
                case 'payment_online':
                    $payment = StatisticService::totalSitePayments($start, $end, $type, 1, 1);
                    $res = array_map(function ($var) {
                        return $var['sum'];
                    }, $payment);

                    break;
                case 'payment_cash':
                    $payment = StatisticService::totalSitePayments($start, $end, $type, 1, 2);
                    $res = array_map(function ($var) {
                        return $var['sum'];
                    }, $payment);
                    break;
                case 'purchase':
                    $payment = StatisticService::totalSitePayments($start, $end, $type, 1, 5);
                    $res = array_map(function ($var) {
                        return $var['sum'];
                    }, $payment);
                    break;

                case 'saman':
                    $payment = StatisticService::totalSamanPayments($start, $end, $type);
                    $res = array_map(function ($var) {
                        return $var['sum'];
                    }, $payment);

                    break;
            }


            echo json_encode($res);

        });

    }


}
