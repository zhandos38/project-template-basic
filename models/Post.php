<?php

namespace app\models;

use kartik\daterange\DateRangeBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $views
 * @property int $user_id
 * @property int $type_id
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property string $author [varchar(255)]
 * @property string $topic [varchar(255)]
 */
class Post extends \yii\db\ActiveRecord
{
    const TYPE_NEWS = 0;
    const TYPE_CLINIC_STATE = 1;
    const TYPE_EXPERT_OPINION = 2;
    const TYPE_RECOMMENDATION = 3;
    const TYPE_PUBLICATION = 4;
    const TYPE_VIDEO_BROADCAST = 5;

    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;
    public $imageFile;

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'createTimeRange',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'image', 'author', 'topic'], 'string'],
            [['views', 'user_id', 'type_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'required'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic' => 'Тема (Только для эксп. мнение)',
            'title' => 'Название',
            'content' => 'Описание',
            'views' => 'Просмотры',
            'user_id' => 'Автор',
            'type_id' => 'Тип',
            'image' => 'Рисунок',
            'author' => 'Автор',
            'created_at' => 'Дата добавление',
            'updated_at' => 'Дата обновление',
            'imageFile' => 'Рисунок'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return array
     */
    public function getTypeLabel()
    {
        return ArrayHelper::getValue(static::getTypes(), $this->type_id);
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_NEWS => 'Новости',
            self::TYPE_CLINIC_STATE => 'Клинически случай',
            self::TYPE_EXPERT_OPINION => 'Экспертное мнение',
            self::TYPE_RECOMMENDATION => 'Рекомендации',
            self::TYPE_PUBLICATION => 'Публикации',
            self::TYPE_VIDEO_BROADCAST => 'Видеотрансляции и архив'
        ];
    }

    public function upload()
    {   $imgPath = \Yii::getAlias('@static');

        if ($this->imageFile == null)
            return true;

        if ($this->validate()) {
            $this->imageFile->saveAs($imgPath . '/web/posts/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function beforeSave($insert)
    {
        if ($this->imageFile)
            $this->image = $this->imageFile->baseName . '.' . $this->imageFile->extension;
        return true;
    }
}
