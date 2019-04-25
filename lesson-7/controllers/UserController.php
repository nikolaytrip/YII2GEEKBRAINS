<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            // 8) Ограничить с помощью AccessControl доступ только для авторизованных пользователей ко всем трем
            // созданным в прошлом ДЗ контроллерам.
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    // В UserController создать экшен test, в нем используя ActiveRecord, т.е. методы классов User и Task,
    // выполнить последовательно, наблюдая выполняемые запросы в debug-панели:
    public function actionTest() {

        // 4.а. Создать запись в таблице user.
//        $user = new User();
//            $user->username = 'yiiUser';
//            $user->password_hash = 'yiiUser';
//            $user->creator_id = 6;
//            $user->created_at = time();

//        _end($user->save());
//        _log($user->save());

        // 4.б. Создать три связаные (с записью в user) запиcи в task, используя метод link().
//        $user4 = User::findOne(4);
//        $task4 = new Task();
//            $task4->title = 'Title_4';
//            $task4->description = 'Description_4';
//            $task4->created_at = time();

//            $task4->link(Task::RELATION_CREATOR, $user4);

//        _end($task4);
//        _log($task4);

//        $user5 = User::findOne(5);
//        $task5 = new Task();
//            $task5->title = 'Title_5';
//            $task5->description = 'Description_5';
//            $task5->created_at = time();

//            $task5->link(Task::RELATION_CREATOR, $user5);

//        _end($task5);
//        _log($task4);

//        $user6 = User::findOne(6);
//        $task6 = new Task();
//        $task6->title = 'Title_6';
//        $task6->description = 'Description_6';
//        $task6->created_at = time();

//        $task6->link(Task::RELATION_CREATOR, $user6);

//        _end($task6);
//        _log($task4);

        // 4.в. Прочитать из базы все записи из User применив жадную подгрузку связанных данных из Task,
        // с запросами без JOIN.
//        $usersNoJoin = User::find()->with(User::RELATION_TASKS)->asArray()->all();

//        _log($usersNoJoin);

        // 4.г. Прочитать из базы все записи из User применив жадную подгрузку связанных данных из Task,
        // с запросом содержащим JOIN.
//        $usersJoin = User::find()->joinWith(User::RELATION_TASKS)->asArray()->all();

//        _log($usersJoin);


        // 5. Добавить в Task метод релейшена getAccessedUsers, связывающий Task и User через релейшен taskUsers,
        // проверить - добавить с помощью созданного релейшена связь между записями в Task и User (метод link())
        // и получить из модели задачи список пользователей которым она доступна.
        $task = Task::findOne(4);
        $user = User::findOne(3);

        $task->link(Task::RELATION_ACCESSED_USERS, $user);

        return $this->render('test');
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (Yii::$app->user->id != User::ADMIN_ID) {
            throw new ForbiddenHttpException('Только админ!');
        }
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
