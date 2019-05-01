<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shared Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-my">

    <h1><?= Html::encode($this->title) ?></h1>
    <!--Во вьюхе shared выводим название и текст задач, кнопку удаления доступа для всех юзеров, работающую с
    подтверждением и отправкой по POST (сделать по аналогии как кнопка удаления во view.php).-->
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'title',
            'description:ntext',
            [
                'label' => 'Users',
                'value' => function (\app\models\Task $model) {
                    return join(', ', $model->getAccessedUsers()->select('username')->column());
                }],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {unshare}',
                'buttons' => [
                    'unshare' => function ($url, $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('remove');
                        return Html::a($icon, ['task-user/delete-all', 'taskId' => $model->id], [
                            'title' => 'Unshare all',
                            'data' => [
                                'confirm' => 'Unshare all?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
