<?php


namespace app\controllers;

use yii\rest\ActiveController;


class UserBaseController extends ActiveController {
  public $modelClass = 'app\models\UserBase';
}