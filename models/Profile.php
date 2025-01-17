<?php

namespace app\models;

use Yii;
use webvimark\modules\UserManagement\models\User;
use yii\helpers\Html;

/**
 * This is the model class for table "profile".
 *
 * @property int $idprofile
 * @property string $name
 * @property string $lastname
 * @property string $gender
 * @property string $birthdate
 * @property int|null $phone
 * @property string|null $address
 * @property string $photo
 * @property string|null $review
 * @property int $fkjobtitle
 * @property int $fkworksin
 * @property int|null $fkuser
 *
 * @property Administrativeunit[] $administrativeunits
 * @property Notifications[] $notifications
 * @property Office[] $offices
 * @property Administrativeunit $fkworksin0
 * @property Jobtitle $fkjobtitle0
 * @property User $fkuser0
 */
class Profile extends \yii\db\ActiveRecord {

    public $avatars;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['name', 'lastname', 'gender', 'birthdate', 'photo', 'fkjobtitle', 'fkworksin'], 'required'],
                [['birthdate'], 'safe'],
                [['fkjobtitle', 'fkworksin', 'fkuser'], 'integer'],
                [['review'], 'string'],
                [['phone'], 'string', 'max' => 15],
                [['name'], 'string', 'max' => 45],
                [['lastname'], 'string', 'max' => 50],
                [['gender'], 'string', 'max' => 10],
                [['address'], 'string', 'max' => 100],
                [['photo'], 'string', 'max' => 255],
                [['avatars'], 'safe'],
                [['avatars'], 'file', 'extensions' => 'jpg, jpeg, png'],
                [['avatars'], 'file', 'maxSize' => '100000000'], 
                [['fkworksin'], 'exist', 'skipOnError' => true, 'targetClass' => Administrativeunit::className(), 'targetAttribute' => ['fkworksin' => 'idadministrativeunit']],
                [['fkjobtitle'], 'exist', 'skipOnError' => true, 'targetClass' => Jobtitle::className(), 'targetAttribute' => ['fkjobtitle' => 'idjobtitle']],
                [['fkuser'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fkuser' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idprofile'  => 'ID',
            'name'       => 'Nombre',
            'lastname'   => 'Apellidos',
            'gender'     => 'Genero',
            'birthdate'  => 'Fecha Nacimiento',
            'phone'      => 'Telefono',
            'address'    => 'Direccion',
            'photo'      => 'Avatar',
            'review'     => 'Reseña',
            'fkjobtitle' => 'Tipo Usuario',
            'fkworksin'  => 'Labora en',
            'fkuser'     => 'ID Usuario',
            'username'   => 'Nombre Usuario',
            'avatars'    => 'Avatar',
        ];
    }

    /**
     * Gets query for [[Administrativeunits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdministrativeunits() {
        return $this->hasMany(Administrativeunit::className(), ['fkheadline' => 'idprofile']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications() {
        return $this->hasMany(Notifications::className(), ['fkprofile' => 'idprofile']);
    }

    /**
     * Gets query for [[Offices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOffices() {
        return $this->hasMany(Office::className(), ['fkto' => 'idprofile']);
    }

    /**
     * Gets query for [[Fkworksin0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkworksin0() {
        return $this->hasOne(Administrativeunit::className(), ['idadministrativeunit' => 'fkworksin']);
    }

    /**
     * Gets query for [[Fkjobtitle0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkjobtitle0() {
        return $this->hasOne(Jobtitle::className(), ['idjobtitle' => 'fkjobtitle']);
    }

    /**
     * Gets query for [[Fkuser0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkuser0() {
        return $this->hasOne(User::className(), ['id' => 'fkuser']);
    }

    public function getWorksin() {
        return $this->getFkworksin0();
    }

    public function getUsername() {
        //var_dump($this->fkuser0); die();
        return $this->fkuser0->username;
    }

    public function getAvatar() {
        return Yii::$app->homeUrl . 'resourcesFiles/avatar/' . $this->photo;
    }

    public function getJobtitle() {
        return $this->fkjobtitle0->jobtitle;
    }

    public function getNamelastname() {
        return $this->name . " " . $this->lastname;
    }

}
