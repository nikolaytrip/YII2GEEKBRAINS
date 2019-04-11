<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property string $created_at
 */
class Product extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    
    public function scenarios() {
        return [
//          self::SCENARIO_DEFAULT => ['name']

           
          self::SCENARIO_UPDATE => ['price', 'created_at']

        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'created_at'], 'required'],
            [['created_at'], 'safe'],
            [['name', 'price'], 'string', 'max' => 20],
            [['name'], 'filter', 'filter' => function($value) {
                    return trim(strip_tags($value));
            }],
            [['price'], 'integer', 'min' => 0, 'max' => 1000, 'on' => 'create'],
            [['price'], 'integer', 'min' => 1000, 'max' => 2000, 'on' => 'update'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'created_at' => 'Создан',
        ];
    }
}
