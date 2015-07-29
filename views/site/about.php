<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'HyperHuman - о проекте';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=$post['text'];?>

</div>
