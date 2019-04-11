<?php

namespace app\controllers;

use app\components\TestService;
use app\models\Product;
use Yii;
use yii\web\Controller;
use app\models\EntryForm;

class TestController extends Controller {

    public function actionIndex() {

        // Выполнить в TestController-е метод компонента test, передать результат выполнения во вьюху и там вывести.
        // $service = new TestService();
        // $service->run();
        $service = \Yii::$app->test->run();

//        $product = new Product();
//        $product->id = 1;
//        $product->name = 'BMW';
//        $product->category = 'auto';
//        $product->price = 200000;

        return $this->render('index', [
//            'product' => $product,
            'service' => $service,

        ]);
    }

    public function actionEntry() {
        $model = new EntryForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            return $this->render('entry', ['model' => $model]);
        }
    }
}