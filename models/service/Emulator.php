<?php
namespace app\models\service;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;


class Emulator
{
    public static function createMockHandler()
    {
        return new MockHandler([
            // Add responses as needed to match the number of requests
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),

            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
            new Response(200, [], json_encode([
                'price' => 150,
                'date' => '2022-01-02',
                'error' => 'no error'
            ])),
        ]);
    }

    public static function createHandlerStack()
    {
        $mock = self::createMockHandler();
        return HandlerStack::create($mock);
    }
}