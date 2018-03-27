<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

?>
<?php //Pjax::begin(['timeout'=>5000]); ?>
<div class="page-view">
    <h3><?= $model->title ?></h3>
</div>

<?php $form = ActiveForm::begin( [
    'method'  => 'get',
    'id'      => 'filter-form',
    'options' => [ 'data-pjax' => true ]
] );
echo $form->field( $model, 'title' );
echo $form->field( $model, 'date' );
echo $form->field( $model, 'text' );
echo Html::submitButton();
$form::end(); ?>
<?php //Pjax::end(); ?>


