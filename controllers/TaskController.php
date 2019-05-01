<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller {
    public $defaultAction = 'my';

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
     * Lists all Task models.
     * @return mixed
     */

    // б) В TaskController cделать экшен my, при создании датапровайдера добавив к $query созданный в пункте
    // "а" метод byCreator($userId) и подставив вместо $userId Id текущего юзера.
    public function actionMy() {
        $query = Task::find()->byCreator(Yii::$app->user->id);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('my', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    //а) Создаем экшен shared - список расшаренных задач, экшен отличается от my тем, что к query создаваемому для
    // датапровайдера присоединен с помощью inner join релейшен taskUsers.
    public function actionShared() {
        $query = Task::find()
            ->byCreator(Yii::$app->user->id)
            ->innerJoinWith(Task::RELATION_TASK_USERS);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('shared', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    // б) Создаем экшен accessed - список доступных чужих задач. Во вьюхе accessed выводим название, текст, имя автора
    // со ссылкой на его страницу просмотра и время создания.
    public function actionAccessed() {
        $query = Task::find()
            ->innerJoinWith(Task::RELATION_TASK_USERS)
            ->where(['user_id' => Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('accessed', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $task = $this->findModel($id);

        if (!$task
            || $task->creator_id !== Yii::$app->user->id
            && !in_array(Yii::$app->user->id, $task->getTaskUsers()->select('user_id')->column())) {
            throw new ForbiddenHttpException();
        }

        if ($task->creator_id !== Yii::$app->user->id) {
            return $this->render('view', [
                'model' => $task,
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => $task->getTaskUsers()
            ]);

            return $this->render('my-view', [
                'model' => $task,
                'dataProvider' => $dataProvider,
            ]);
        }


    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // д) В методе actionCreate добавить флэш сообщение об успешном создании и поменять редирект после создания
    // на созданный список своих задач.
    // в) Добавляем флэш-сообщения после создания, изменения и удаления.
    public function actionCreate() {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Задача добавлена!');
            return $this->redirect(['my']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // в) Добавляем флэш-сообщения после создания, изменения и удаления.
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if (!$model || $model->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('warning', 'Задача обновлена!');
            return $this->redirect(['my']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'my' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // в) Добавляем флэш-сообщения после создания, изменения и удаления.
    public function actionDelete($id) {
        $model = $this->findModel($id);

        if (!$model || $model->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model->delete();

        Yii::$app->session->setFlash('danger', 'Задача удалена!');

        return $this->redirect(['my']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
