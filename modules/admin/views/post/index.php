<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Post;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \common\models\Post */

$this->title = 'Посты';
$this->params['breadcrumbs'][] = $this->title;

$imgPath = Yii::$app->params['staticDomain'] . 'posts/';
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить пост', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'value' => function(Post $model) use ($imgPath) {
                    $imgPath .= $model->image;
                    return "<img src='$imgPath' width='250'>";
                },
                'format' => 'html'
            ],
            'title',
            [
                'attribute' => 'content',
                'format' => 'text',
            ],
            'views',
            [
                'attribute' => 'user_id',
                'value' => function(Post $model) {
                    return $model->user->full_name;
                }
            ],
            [
                'attribute' => 'type_id',
                'value' => function(Post $model) {
                    return $model->getTypeLabel();
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function(Post $model) {
                    return date('d-m-Y H:i', $model->created_at);
                }
            ],

            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
