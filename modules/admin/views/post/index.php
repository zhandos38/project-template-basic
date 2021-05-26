<?php
use app\models\Post;
use kartik\daterange\DateRangePicker;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Посты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <a class="btn btn-success" href="<?= \yii\helpers\Url::to(['post/create']) ?>">Добавить</a>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'created_at',
                'value' => function(Post $model) {
                    return date('d-m-Y H:i', $model->created_at);
                },
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'createTimeRange',
                    'convertFormat' => true,
                    'pjaxContainerId' => 'crud-datatable-pjax',
                    'pluginOptions' => [
                        'locale' => [
                            'format'=>'Y-m-d'
                        ],
                        'convertFormat'=>true
                    ]
                ]),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]) ?>

</div>
