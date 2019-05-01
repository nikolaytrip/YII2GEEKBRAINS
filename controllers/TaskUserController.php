<?php

namespace app\controllers;

use app\models\Task;
use app\models\User;
use Yii;
use app\models\TaskUser;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskUserController implements the CRUD actions for TaskUser model.
 */
class TaskUserController extends Controller {
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
            // добавить экшен в VerbFilter для выполнения только по POST.
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-all' => ['POST']
                ],
            ],
        ];
    }

    // б) Удаляем экшены index, update и view.

    /**
     * Creates a new TaskUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // а) В экшене create присваем атрибуту task_id модели значение taskId из урла и создаем список пользователей,
    // кроме текущего, для выпадающего списка. Добавить флэш сообщение и поменять редирект после создания на
    // созданный список своих задач.
    public function actionCreate($taskId) {
        $model = Task::findOne($taskId);
        // в) Сделать проверку автора заметки при создании доступа.
        // г) Проверяем как работает создание доступа.
        if (!$model || $model->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }
        $model = new TaskUser();
        $model->task_id = $taskId;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Create success');
            return $this->redirect(['task/my']);
        }

        $users = User::find()
            ->where(['<>', 'id', Yii::$app->user->id])
            ->select('username')
            ->indexBy('id')
            ->column();

        return $this->render('create', [
            'model' => $model,
            'users' => $users,
        ]);
    }

    /**
     * Creates a new TaskUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // а) Сделать экшен deleteAll для удаления доступов к задаче.
    // Сделать проверку на то, что удаляем доступы именно к своей задаче
    // После удаления добавляем флэш-сообщение и редирект после на /task/shared.
    public function actionDeleteAll($taskId) {
        $model = Task::findOne($taskId);
        if (!$model || $model->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model->unlinkAll(Task::RELATION_ACCESSED_USERS, true);

        Yii::$app->session->setFlash('success', 'Все доступы удалены!');

        return $this->redirect(['task/shared']);
    }

    /**
     * Deletes an existing TaskUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // 2) В экшене task-user/delete реализовать проверку удаления доступа именно к своей задаче
    public function actionDelete($taskUserId) {

        $model = $this->findModel($taskUserId);

        if ($model->getTask()->one()->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model->delete();
        // Добавить флэш сообщение после удаления.
        Yii::$app->session->setFlash('danger', 'Пользователь удален из данной задачи!');

        return $this->redirect(['task/view', 'id' => $model->getTask()->one()->id]);
    }

    /**
     * Finds the TaskUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TaskUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
