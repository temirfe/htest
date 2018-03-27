<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $response */

?>
<?php Pjax::begin(); ?>
<?= Html::a("Show Date", ['page/date'], ['class' => 'btn btn-lg btn-success']) ?>
<h1>It's: <?= $response ?></h1>
<?php Pjax::end(); ?>


