<?php

use webvimark\modules\UserManagement\models\User;
use webvimark\extensions\BootstrapSwitch\BootstrapSwitch;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use webvimark\modules\UserManagement\models\UserVisitLog;
$token = Yii::$app->session->get('__visitorToken');
if ($token) {
    $log_model = UserVisitLog::find()->where(['token' => $token])->one();
    $log_model->exit_time = time();
    $log_model->duration = gmdate("H:i:s",$log_model->exit_time - $log_model->visit_time);
    $log_model->save(false);
}
/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $model
 */

$this->title = UserManagementModule::t('back', 'Editing user: ') . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = UserManagementModule::t('back', 'Editing');
?>
<div class="user-update">

    <h2 class="lte-hide-title"><?= $this->title ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <?= $this->render('_form', compact('model')) ?>
        </div>
    </div>

</div>