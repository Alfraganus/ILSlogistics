<?php

namespace app\controllers;

use yii\web\Controller;
use GuzzleHttp\Client;
use app\models\service\DeliveryHelperService;
use app\models\service\MockHelper;

class DeliveryController extends Controller
{
   public function actionRun()
   {
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

       $client = new Client(['handler' => MockHelper::createFakeOrders()]);

       return (new DeliveryHelperService('https://any-test-url.com', $client))
           ->executeDelivery(
               MockHelper::$orders,
               DeliveryHelperService::SLOW_DELIVERY
           );
   }
}
