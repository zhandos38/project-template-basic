<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\imagine\Image;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string|null $img
 * @property string|null $content
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
    public $imageFile;

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className()
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
            [['title'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'img'], 'string', 'max' => 255],

            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование',
            'img' => 'Рисунок',
            'imageFile' => 'Рисунок',
            'content' => 'Контент',
            'created_at' => 'Время добавления',
            'updated_at' => 'Время обновления',
        ];
    }

    public function getDate()
    {
        return date('Y.m.d', $this->created_at);
    }

    public function getShortDescription()
    {
        if (strlen($this->content) >= (int)255) {
            return str_replace("<br>", "", mb_strcut($this->content, 0, 255)) . '...';
        }

        return false;
    }

    public function getImage()
    {
        return Yii::$app->params['staticDomain'] . '/post/' . $this->img;
    }

    public function upload()
    {
        if ($this->imageFile === null) {
            return true;
        }

        $folderPath = Yii::getAlias('@static') . '/post';

        if (!file_exists($folderPath) && !mkdir($folderPath, 0777, true) && !is_dir($folderPath)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $folderPath));
        }

        $imgPath = $folderPath . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;

        if ($this->validate()) {
            $this->imageFile->saveAs($imgPath);
            return Image::resize($imgPath,500, 500, true)->save();
        }

        return false;
    }
}
