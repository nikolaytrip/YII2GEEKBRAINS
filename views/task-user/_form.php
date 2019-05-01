<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaskUser */
/* @var $form yii\widgets\ActiveForm */
/* @var $users array */
?>

<div class="task-user-form">

    <?php $form = ActiveForm::begin(); ?>

<!--б) Изменяем вьюху _form - удалив поле task_id и заменив user_id выпадающим списком с переданным из контроллера
    массивом пользователей.-->
    <?= $form->field($model, 'user_id')->dropDownList($users) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
