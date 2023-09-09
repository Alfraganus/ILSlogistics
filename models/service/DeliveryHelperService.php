<?php

namespace app\models\service;

class DeliveryHelperService
{
    private $baseUrl;
    private $client;

    const FAST_DELIVERY = 'fast';
    const SLOW_DELIVERY = 'slow';
    public function __construct($baseUrl, $client)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
    }

    private array $allowedFields = [
        'sourceKladr',
        'targetKladr',
        'weight'
    ];

    public function executeDelivery($deliveries,$deliveryType)
    {
        $results = [];
        foreach ($deliveries as $delivery) {
            if (!$this->isDeliveryDataValid($delivery)) {
                throw new \Exception("Wrong parameter has been given!",400);
            }
            $deliveryType == self::FAST_DELIVERY ?
                $results[] = $this->getFastDelivery($delivery) :
                $results[] = $this->getSlowDelivery($delivery);
        }

        return $results;
    }

    public function isDeliveryDataValid($data)
    {
        foreach ($this->allowedFields as $field) {
            if (empty($data[$field]))  return false;
        }
        return true;
    }

    public function getFastDelivery($data)
    {
        return $this->sendDeliveryRequest('fast_delivery', $data);
    }

    public function getSlowDelivery($data)
    {
        return $this->sendDeliveryRequest('slow_delivery', $data);
    }

    private function sendDeliveryRequest($endpoint, $data)
    {
        $url = $this->baseUrl . '/' . $endpoint;

        try {
            $response = $this->client->request('GET', $url, ['query' => $data]);
            $body = $response->getBody()->getContents();
            return json_decode($body, true);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}