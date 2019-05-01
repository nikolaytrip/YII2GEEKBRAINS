<?php

namespace app\models;

use phpDocumentor\Reflection\Types\Self_;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property int $creator_id
 * @property int $updater_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property TaskUser[] $taskUsers
 * @mixin TimestampBehavior
 */
// 3) Имплементировать в User интерфейс IdentityInterface и реализовать необходимые методы как показано здесь
// https://www.yiiframework.com/doc/guide/2.0/ru/security-authentication#implementing-identity
class User extends \yii\db\ActiveRecord implements IdentityInterface {

    const RELATION_TASKS = 'tasks';
    const ADMIN_ID = 9;

    // 2) Создать в классе User свойство password и добавить его в одно из правил rules(), убрать password_hash из правил.
    public $password;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user';
    }

    // 4) Реализовать там же в методе beforeSave хэширование непустого пароля в аттрибут password_hash
    // (https://www.yiiframework.com/doc/guide/2.0/ru/security-passwords) и заполнение случайной строкой аттрибута
    // auth_key при создании записи (см. пример beforeSave по ссылке 3 пункта).
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->password) {
                $this->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
            }
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    // 2) Создать в классе User свойство password и добавить его в одно из правил rules(), убрать password_hash из правил.
    public function rules() {
        return [
            [['username', 'password'], 'required'],
            [['creator_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 255],
        ];
    }

    public function behaviors() {
        return [
            // 1) Подключить в классах User и Task поведение TimestampBehavior
            TimestampBehavior::class,
            // 7) Подключить поведение BlameableBehavior в классах User и Task.
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks() {
        return $this->hasMany(Task::className(), ['creator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0() {
        return $this->hasMany(Task::className(), ['updater_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskUsers() {
        return $this->hasMany(TaskUser::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find() {
        return new \app\models\query\UserQuery(get_called_class());
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User
     */
    // 5) Реализовать в User методы validatePassword($password) и findByUsername($name).
    // Первый проверит пароль сравнив его хэш с текушим значением из атрибута password_hash, проверка описана по
    // последней ссылке. Второй вернет модель пользователя по значению username.
    public static function findByUsername($username) {
        return self::findOne(['username' => $username]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return false;
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
