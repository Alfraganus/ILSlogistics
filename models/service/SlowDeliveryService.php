<?php

namespace app\models\service;
use app\dto\DeliveryResult;
use app\interfaces\DeliveryServiceInterface;

class SlowDeliveryService implements DeliveryServiceInterface
{
    const BASE_COST = 150;

    public function calculateDelivery($sourceKladr, $targetKladr, $weight)
    {
        $coefficient = $this->calculateCoefficient($weight);
        $deliveryDate = $this->calculateDeliveryDate();

        $price = self::BASE_COST * $coefficient;

        return new DeliveryResult($price, $deliveryDate, null);
    }

    private function calculateCoefficient($weight)
    {
        return 1.0;
    }

    public function calculateDeliveryDate($daysToAdd) // random days after today to next 3 days
    {
        $currentTimestamp = time();

        $maxTimestamp = strtotime('+3 days', $currentTimestamp);
        $randomTimestamp = mt_rand($currentTimestamp, $maxTimestamp);
        $randomDate = date('d-m-Y', $randomTimestamp);

        return $randomDate;
    }

    public function calculatePrice($basePrice, $weight)
    {
        return $basePrice * $weight;
    }
}