<?php

/* @var $this yii\web\View */
/* @var $model app\models\EntryForm */

use yii\helpers\Html;
?>
<p>Вы ввели следующую информацию: </p>
<ul>
  <li><label>Name</label>: <?= Html::encode($model->name) ?></li>
  <li><label>Email</label>: <?= Html::encode($model->email) ?></li>
</ul>
