<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-my">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
<!--в) Создать вьюху my скопировав или изменив вьюху index - в таблице д.б. только столбцы title, description, -->
<!--created_at,updated_at,действия. Убедиться, что теперь в списке задач выводятся только созданные текущим пользователем.-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'title',
            'description:ntext',
            'created_at:datetime',
            'updated_at:datetime',

            // г) Добавить в столбце действий ссылку с иконкой на /task-user/create/?taskId=ид_задачи
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {share}',
                'buttons' => [
                    'share' => function ($url, $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('share');
                        return Html::a($icon, ['task-user/create', 'taskId' => $model->id]);
                    },
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
