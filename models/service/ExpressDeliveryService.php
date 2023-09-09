<?php

namespace app\models\service;


class ExpressDeliveryService implements DeliveryServiceInterface
{
    public function calculateDelivery($sourceKladr, $targetKladr, $weight)
    {
        $basePrice = 10;
        $daysToAdd = 2;

        $price = $this->calculatePrice($basePrice, $weight);
        $deliveryDate = $this->calculateDeliveryDate($daysToAdd);

        return new DeliveryResult($price, $deliveryDate, null);
    }

    public function calculatePrice($basePrice, $weight)
    {
        return $basePrice * DeliveryHelperService::weightPrice($weight);
    }

    public function calculateDeliveryDate($daysToAdd) // random hour, any hour for next 24
    {
        $currentTimestamp = time();
        $nextDayTimestamp = strtotime('tomorrow', $currentTimestamp);
        $maxTimestamp = strtotime('+1 day', $nextDayTimestamp);
        $randomTimestamp = mt_rand($nextDayTimestamp, $maxTimestamp);
        $randomHour = date('H', $randomTimestamp);

        return $randomHour;
    }
}