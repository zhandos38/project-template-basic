<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = 'Обновить пост: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Panels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
