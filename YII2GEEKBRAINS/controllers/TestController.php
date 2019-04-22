<?php

namespace app\controllers;

use app\components\TestService;
use app\models\Product;
use app\models\Task;
use Yii;
use yii\db\Query;
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

        $task = new Task();
        $task->description = 'Description_7';
        $task->title = 'Title_7';
        $task->creator_id = 1;
        $task->save();

        _end($task);

        return $this->render('index', [
//            'product' => $product,
            'service' => $service,

        ]);
    }

    public function actionInsert() {
        // В экшене insert TestController-а через Yii::$app->db->createCommand()->insert() вставить несколько записей в
        // таблицу user, в поле password_hash можно вставить произвольные значения, поле id заполняется автоматически.
//        $dataInsert = \Yii::$app->db->createCommand()->insert('user', [
//            'username' => 'john',
//            'password_hash' => 'john',
//            'auth_key' => '',
//            'creator_id' => '5',
//            'updater_id' => '',
//            'created_at' => '1555530889',
//            'updated_at' => ''
//        ])->execute();

        // В экшене insert TestController-а через Yii::$app->db->createCommand()->batchInsert() вставить одним вызовом
        // сразу 3 записи в таблицу task, в поле creator_id подставив реальное значение id из user (просто числом).
        $dataBatchInsert = \Yii::$app->db->createCommand()
            ->batchInsert('task', ['title', 'description', 'creator_id', 'created_at'], [
                ['Title_1', 'Description_1', '1', '1555271689'],
                ['Title_2', 'Description_2', '2', '1555271689'],
                ['Title_3', 'Description_3', '3', '1555271689'],
        ])->execute();

        return $this->render('insert');
    }

    public function actionSelect() {

        // Используя \yii\db\Query в экшене select TestController выбрать из user:
        $query = new Query();

        // Запись с id=1
//        $dataUserId1 = $query->from('user')->where(['id' => 1])->all();
//        _end($dataUserId1);

        // Все записи с id>1 отсортированные по имени (orderBy())
//        $dataUsers = $query->from('user')->where(['>', 'id', '1'])->orderBy(['username' => SORT_ASC])->all();
//        _end($dataUsers);

        // Количество записей.
//        $dataCount = $query->from('user')->count();
//        _end($dataCount);

//        _log($dataSelect);

        // Используя \yii\db\Query в экшене select TestController-а вывести содержимое task
        // с присоединенными по полю creator_id записями из таблицы user (innerJoin())
        $dataTask = $query->from('task')
            ->innerJoin('user', 'user.creator_id = task.creator_id')->all();
        _end($dataTask);

        return $this->render('select');

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