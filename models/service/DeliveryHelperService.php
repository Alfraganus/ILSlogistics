<?php

namespace app\models\service;

use GuzzleHttp\Client;

class DeliveryHelperService
{
    private $baseUrl;
    private $client;

    public function __construct($baseUrl, $client)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
    }

    public function calculateDeliveryCost($deliveries)
    {
        $results = [];
        foreach ($deliveries as $delivery) {
            if (!$this->validateDeliveryData($delivery)) {
                continue;
            }
            $results[] = $this->getFastDelivery($delivery);
            $results[] = $this->getSlowDelivery($delivery);
        }

        return $results;
    }

    public function validateDeliveryData($data)
    {
        $requiredKeys = ['sourceKladr', 'targetKladr', 'weight'];
        foreach ($requiredKeys as $key) {
            if (empty($data[$key])) {
                return false;
            }
        }

        return true;
    }

    public function getFastDelivery($data)
    {
        $url = $this->baseUrl . '/fast_delivery';
        try {
            $response = $this->client->request('GET', $url, ['query' => $data]);
            $body = $response->getBody()->getContents();
            return json_decode($body, true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getSlowDelivery($data)
    {
        $url = $this->baseUrl . '/slow_delivery';
        try {
            $response = $this->client->request('GET', $url, ['query' => $data]);
            $body = $response->getBody()->getContents();
            return json_decode($body, true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function test()
    {
        $handlerStack = Emulator::createHandlerStack();
        $client = new Client(['handler' => $handlerStack]);
        $baseUrl = 'https://example.com';  // Базовый URL для API доставки

        $deliveries = [
            [
                'sourceKladr' => 'kladr1',
                'targetKladr' => 'kladr2',
                'weight' => 1.5
            ],
            [
                'sourceKladr' => 'kladr3',
                'targetKladr' => 'kladr4',
                'weight' => 2.0
            ]
        ];

        $calculator = new self($baseUrl, $client);
        $results = $calculator->calculateDeliveryCost($deliveries);

        foreach ($results as $result) {
            print_r($result);
        }
    }
}
