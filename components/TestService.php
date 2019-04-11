<?php

//Создать в папке components файл TestService с классом TestService унаследованным от Component,
//в нем создать свойство и метод возвращающий значение свойства, проверьте namespace.

namespace app\components;

use yii\base\Component;

class TestService extends Component {

    public $prop = 'default';

    public function run() {
        return $this->prop;
    }

}