<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\forms\RegistrationForm $model
 */

$this->title = UserManagementModule::t('front', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container" id="registration-wrapper">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= UserManagementModule::t('front', 'New Account Setup') ?></h3>
                </div>
                <div class="panel-body">

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => [],
                        'validateOnBlur' => false,
                        'fieldConfig' => [
                            'template' => "{input}\n{error}",
                        ],
                    ]) ?>
                    <?= $form->field($model, 'sales_id')
                        ->textInput(['maxlength' => 50, 'placeholder' => 'Your Capital Accounts client number', /*'autocomplete' => 'off'*/]) ?>

                    <?= $form->field($model, 'zip')
                        ->textInput(['maxlength' => 50, 'placeholder' => 'Zip Code as it appears on your monthly statement',]) ?>

                    <?= $form->field($model, 'username')
                        ->textInput(['maxlength' => 50, 'placeholder' => 'Email (Will be a Login)',]) ?>

                    <?= $form->field($model, 'password')
                        ->passwordInput(['placeholder' => $model->getAttributeLabel('password'),]) ?>

                    <?= $form->field($model, 'repeat_password')
                        ->passwordInput(['placeholder' => $model->getAttributeLabel('repeat_password'), 'maxlength' => 255,]) ?>

                    <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-sm-2">{image}</div><div class="col-sm-10">{input}</div></div>',
                        'captchaAction' => ['/user-management/auth/captcha']
                    ]) ?>

                    <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> ' .
                        UserManagementModule::t('front', 'Register'),
                        ['class' => 'btn btn-lg btn-primary btn-block']
                    ) ?>

                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$css = <<<CSS
html, body {
	background: #eee;
	/*-webkit-box-shadow: inset 0 0 100px rgba(0,0,0,.5);*/
	/*box-shadow: inset 0 0 100px rgba(0,0,0,.5);*/
	height: 100%;
	min-height: 100%;
	position: relative;
}
#registration-wrapper {
	position: relative;
	top: 5%;
}
CSS;

$this->registerCss($css);
?>
