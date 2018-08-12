<?php

namespace kntodev\simplemessage\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use kntodev\simplemessage\Message ;
use kntodev\simplemessage\models\Messages;
use kntodev\simplemessage\models\MessagesSearch;
use kntodev\simplemessage\helpers\TimeElapsed;

/**
 * Default controller for the `simplemessage` module
 */
class DefaultController extends Controller
{

    public $layout = "@app/views/layouts/main";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete', 'create'], 
                'rules' => [
                    [
                        'allow' => false,
                        'verbs' => ['POST'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'create'],
                        'roles' => ['messageUser'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList() {
        $msgData = $this->getMsgs4CurrentUser() ;
        $shortMsg = false; 
        foreach ($msgData as $msg) {
             $shortMsg[] = (object) array(
                'route' => $msg->route.$msg->id ,
                'subject' => $msg->subject ,
                'timeago' => TimeElapsed::timeElapsed($msg->created_at),
             );
        }

        return $this->renderAjax('short', [
            'dataProvider' => $shortMsg,
        ]);
    }

    /**
     * Renders the create view for the module
     * @return string
     */
    public function actionCreate()
    {
        $model = new Messages();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Message::create([
                'receiver' => $model->users,
                'subject' => $model->subject,
                'content' => $model->content,
            ])->send() ;

            return $this->redirect(Yii::$app->homeUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);

        return $this->render('create');
    }

    public function actionView($id)
    {
        Messages::setReaded($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function getMsgs4CurrentUser() {
        $actualUser = Yii::$app->user->identity->id ;
        return Messages::find()
        ->where("(receiver = $actualUser) AND (readed = 0)")
        ->all();
    }

    protected function getAllMsgs() {
        if (Yii::$app->user->identity->isAdmin) {
            return Messages::find()->all();
        }
        return Messages::find()
        ->where('receiver = Yii::$app->user->identity->id')
        ->all();
    }

    protected function findModel($id)
    {
        if (($model = Messages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
