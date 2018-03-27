<?php
namespace app\components\hello;

use yii\base\Widget;
use yii\helpers\Html;
use app\components\hello\HelloAsset;

class HelloWidget extends Widget
{
    public $message;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Hello World';
        }
        HelloAsset::register($this->view);
    }

    public function run()
    {
        //return Html::encode($this->message);
        return $this->render('hello',['message'=>$this->message]);
    }
}
