<?php

/* @var $this yii\web\View */
/* @var $service \app\components\TestService */

use yii\helpers\Html;

$this->title = 'Test page';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-hello">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Test Hello, World!
    </p>

    <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda commodi nostrum quidem unde. Aperiam iste
        iure nam officia officiis quia, quisquam repellat? Commodi consequatur deserunt dignissimos quam sapiente
        voluptas voluptate.
    </p>

    <h3><?php echo $service ?></h3>

</div>

