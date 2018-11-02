<?php

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

$this->title = UserManagementModule::t('back', 'Changing password for user: ') . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = UserManagementModule::t('back', 'Changing password');
?>
<div class="user-update">

    <h2 class="lte-hide-title"><?= $this->title ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="user-form">

                <?php $form = ActiveForm::begin([
                    'id'=>'user',
                    'layout'=>'horizontal',
                ]); ?>

                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>

                <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <?php if ( $model->isNewRecord ): ?>
                            <?= Html::submitButton(
                                '<span class="glyphicon glyphicon-plus-sign"></span> ' . UserManagementModule::t('back', 'Create'),
                                ['class' => 'btn btn-success']
                            ) ?>
                        <?php else: ?>
                            <?= Html::submitButton(
                                '<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Save'),
                                ['class' => 'btn btn-primary']
                            ) ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>
