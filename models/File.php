<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $idfile
 * @property string $file
 *
 * @property Officefile[] $officefiles
 * @property Office[] $idoffices
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idfile' => 'Idfile',
            'file' => 'File',
        ];
    }

    /**
     * Gets query for [[Officefiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOfficefiles()
    {
        return $this->hasMany(Officefile::className(), ['idfile' => 'idfile']);
    }

    /**
     * Gets query for [[Idoffices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdoffices()
    {
        return $this->hasMany(Office::className(), ['idoffice' => 'idoffice'])->viaTable('officefile', ['idfile' => 'idfile']);
    }
}