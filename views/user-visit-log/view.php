<?php

use webvimark\modules\UserManagement\models\UserVisitLog;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\Html;
use yii\widgets\DetailView;

$token = Yii::$app->session->get('__visitorToken');
if ($token) {
    $log_model = UserVisitLog::find()->where(['token' => $token])->one();
    $log_model->exit_time = time();
    $log_model->duration = gmdate("H:i:s",$log_model->exit_time - $log_model->visit_time);
    $log_model->save(false);
}
/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\UserVisitLog $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Visit log'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$token = Yii::$app->session->get('__visitorToken');
if ($token) {
    $log_model = UserVisitLog::find()->where(['token' => $token])->one();
    $log_model->exit_time = time();
    $log_model->duration = gmdate("H:i:s",$log_model->exit_time - $log_model->visit_time);
    $log_model->save(false);
}
?>
<div class="user-visit-log-view">


    <div class="panel panel-default">
        <div class="panel-body">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute'=>'user_id',
                        'value'=>@$model->user->username,
                    ],
                    'ip',
                    'language',
                    'os',
                    'browser',
                    'user_agent',

                    'visit_time:datetime',
                ],
            ]) ?>

        </div>
    </div>
</div>
