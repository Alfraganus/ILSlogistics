<?php

namespace app\controllers;

use app\models\service\DeliveryHelperService;
use app\models\service\Emulator;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use GuzzleHttp\Client;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
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
                'weight' => 3.0
            ],
            [
                'sourceKladr' => 'kladr3',
                'targetKladr' => 'kladr4',
                'weight' => 3.0
            ],
            [
                'sourceKladr' => 'kladr1',
                'targetKladr' => 'kladr2',
                'weight' => 1.5
            ],
            [
                'sourceKladr' => 'kladr3',
                'targetKladr' => 'kladr4',
                'weight' => 3.0
            ],
            [
                'sourceKladr' => 'kladr3',
                'targetKladr' => 'kladr4',
                'weight' => 3.0
            ],
        ];

        $calculator = new DeliveryHelperService($baseUrl, $client);
        $results = $calculator->calculateDeliveryCost($deliveries);

// Возвращаем результат
        echo  "<pre>";
        foreach ($results as $result) {
            print_r($result);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
