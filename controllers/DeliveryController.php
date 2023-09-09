<?php

namespace app\controllers;

use app\models\service\DeliveryHelperService;
use app\models\service\MockHelper;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use GuzzleHttp\Client;
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
