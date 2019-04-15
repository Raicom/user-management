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
                    <h3 class="panel-title"><?= UserManagementModule::t('front', 'Registration of new client (CABO)') ?></h3>
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
                    <?= $form->field($model, 'name')
                        ->textInput(['maxlength' => 50, 'placeholder' => $model->getAttributeLabel('name'), /*'autocomplete' => 'off'*/]) ?>

                    <?php
                    $business_types = ArrayHelper::map(common\models\LutBusinessType::find()->orderBy('name')->asArray()->all(), 'id', 'name');
                    echo $form->field($model, 'lut_business_type_id')->dropDownList($business_types, ['prompt' => 'Type of Business...']);
                    ?>

                    <?= $form->field($model, 'years_in_business')
                        ->textInput(['maxlength' => 50, 'placeholder' => $model->getAttributeLabel('years_in_business'),]) ?>

                    <?= $form->field($model, 'contact')
                        ->textInput(['maxlength' => 50, 'placeholder' => $model->getAttributeLabel('contact'),]) ?>

                    <?= $form->field($model, 'address_1')
                        ->textInput(['maxlength' => 50, 'placeholder' => $model->getAttributeLabel('address_1'),]) ?>

                    <?= $form->field($model, 'address_2')
                        ->textInput(['maxlength' => 50, 'placeholder' => $model->getAttributeLabel('address_2'),]) ?>

                    <?= $form->field($model, 'city')
                        ->textInput(['maxlength' => 50, 'placeholder' => $model->getAttributeLabel('city'),]) ?>

                    <?php
                    $state_names = ArrayHelper::map(common\models\LutState::find()->orderBy('name')->asArray()->all(), 'id', 'name');
                    echo $form->field($model, 'lut_state_id')->dropDownList($state_names, ['prompt' => 'State...']);
                    ?>

                    <?= $form->field($model, 'zip')
                        ->textInput(['maxlength' => 50, 'placeholder' => $model->getAttributeLabel('zip'),]) ?>

                    <?= $form->field($model, 'phone')
                        ->textInput(['maxlength' => 50, 'placeholder' => $model->getAttributeLabel('phone'),]) ?>

                    <?= $form->field($model, 'website')
                        ->textInput(['maxlength' => 50, 'placeholder' => $model->getAttributeLabel('website'),]) ?>

                    <?= $form->field($model, 'email_notifications')
                        ->textInput(['maxlength' => 50, 'placeholder' => $model->getAttributeLabel('email_notifications'),]) ?>

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

                    <?php
                    $model->type = 1;
                    $model->balance = 0;
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->updated_at = date('Y-m-d H:i:s');

                    echo $form->field($model, 'type')->textInput()->hiddenInput();
                    echo $form->field($model, 'balance')->textInput()->hiddenInput();
                    echo $form->field($model, 'created_at')->textInput()->hiddenInput();
                    echo $form->field($model, 'updated_at')->textInput()->hiddenInput();


                    ?>

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
