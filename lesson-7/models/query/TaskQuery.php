<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Task]].
 *
 * @see \app\models\Task
 * @return TaskQuery
 */

    // Необходимо сделать экшен для показа списка своих заметок и настроить экшен для создания задач:
class TaskQuery extends \yii\db\ActiveQuery
{
    //  а) В TaskQuery сделать метод byCreator($userId), который должен добавлять условие по id создателя
    // (creator_id = $userId). Для этого можно изменить имеющийся там закоментированный метод active().
    public function byCreator($userId)
    {
        return $this->andWhere(['creator_id' => $userId]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Task[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Task|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
