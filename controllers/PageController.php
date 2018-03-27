<?php

namespace app\controllers;

use Yii;
use app\models\Page;
use app\models\PageSearch;
use yii\base\Security;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PageElastic;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();
        $model->date=date('Y-m-d');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIndexify()
    {
        $dao=Yii::$app->db;
        $rows=$dao->createCommand("SELECT * FROM Page")->queryAll();
        PageElastic::createIndex();
        foreach($rows as $row){
            $elastic = new PageElastic();
            $elastic->primaryKey=$row['id'];
            $elastic->id=$row['id'];
            $elastic->title=$row['title'];
            $elastic->text=$row['text'];
            $elastic->date=$row['date'];
            if ($elastic->insert()) {
                echo "Added Successfully <br />";
            } else {
                echo "Error";
            }
        }
    }

    public function actionDelastic(){
        $row=PageElastic::get(5);
        $row->delete();
    }

    public function actionUpdastic(){
        $row=PageElastic::get(5);
        $row->title='love is love';
        $row->update();
    }

    public function actionQuestic(){
        $result = PageElastic::find()->query(["match" => ["title" => "love"]])->one();
        foreach($result as $key=>$value){
            echo $key."= > ".$value."<br />";
        }
    }


    /**
     * Testing pjax
     */
    public function actionXajp()
    {
        $model = new Page();
        $get=Yii::$app->request->get();
        $model->load($get);
        if(!$model->title && !empty($get['title'])){$model->title=$get['title'];}
        
        return $this->render('xajp', [
            'model' => $model,
        ]);
    }

    public function actionDate()
    {
        return $this->render('date', ['response' => date('Y-M-d')]);
    }
}
