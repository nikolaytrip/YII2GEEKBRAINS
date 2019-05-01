<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'creator_id:datetime',
            'updater_id:datetime',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <!--Во вьюхе task/view только для своей задачи! вывести в помощью Gridview список всех доступов (TaskUser), которых
    предоставили другим пользователям. В таблице сделать одну кнопку - удаления, ведущую на task-user/delete, передающую в
    параметре id для task_user и работающую по POST.-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Shared Users',
                'value' => function (app\models\TaskUser $model) {
                    return $model->getUser()->one()->username;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{unshare}',
                'buttons' => [
                    'unshare' => function ($url, $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('remove');
                        return Html::a($icon, ['task-user/delete', 'taskUserId' => $model->id], [
                            'title' => 'Unshare user',
                            'data' => [
                                'confirm' => 'Unshare user?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
