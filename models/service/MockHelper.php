<?php
namespace app\models\service;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;


class MockHelper
{
    public static function createMockHandler()
    {
        $result = [];
        for ($i=0;$i<=11;$i++) {
            $result[] =  new Response(200, [], json_encode([
                'price' => rand(100, 200),
                'date' => self::randomDateGenerator(),
                'error' => ''
            ]));
        }
        return new MockHandler($result);
    }
    private static function randomDateGenerator()
    {
        $end_date = strtotime('2024-12-31');
        $start_date = strtotime('2023-01-01');
        $random_timestamp = rand($start_date, $end_date);

        return date('Y-m-d', $random_timestamp);
    }

    public static function createFakeOrders()
    {
        $mock = self::createMockHandler();
        return HandlerStack::create($mock);
    }
    public static array $orders = [
        [
            'sourceKladr' => 'kladr1',
            'targetKladr' => 'kladr2',
            'weight' => 1.5
        ],
        [
            'sourceKladr' => 'kladr3',
            'targetKladr' => 'kladr4',
            'weight' => 2.0
        ],
        [
            'sourceKladr' => 'kladr5',
            'targetKladr' => 'kladr6',
            'weight' => 2.5
        ],
        [
            'sourceKladr' => 'kladr7',
            'targetKladr' => 'kladr8',
            'weight' => 3.0
        ],
        [
            'sourceKladr' => 'kladr9',
            'targetKladr' => 'kladr10',
            'weight' => 3.5
        ],
        [
            'sourceKladr' => 'kladr11',
            'targetKladr' => 'kladr12',
            'weight' => 4.0
        ],
    ];
}