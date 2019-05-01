<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accessed Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-my">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function (\app\models\Task $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                }
            ],
            'description:ntext',
            [
                'attribute' => 'creator.username',
                'format' => 'html',
                'value' => function (\app\models\Task $model) {
                    return Html::a($model->getCreator()->one()->username, ['user/view', 'id' => $model->creator_id]);
                }
            ],
            'created_at:datetime',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
