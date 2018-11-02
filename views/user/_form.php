<?php

use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use webvimark\extensions\BootstrapSwitch\BootstrapSwitch;
use app\models\States;
use app\models\UserDirection;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>

    <div class="user-form">

        <?php $form = ActiveForm::begin([
            'id'=>'user',
            'layout'=>'horizontal',
            'validateOnBlur' => false,
        ]); ?>

        <?= $form->field($model->loadDefaultValues(), 'status')
            ->dropDownList(User::getStatusList()) ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>
        <?php
        $test_names = ArrayHelper::map(States::find()->orderBy('code')->asArray()->all(), 'state_id', 'code');
        echo $form->field($model, 'state_id')->dropDownList($test_names, ['prompt'=>'Select...'])->label('Office state');
        $directions = ArrayHelper::map(UserDirection::find()->orderBy('direction_id')->asArray()->all(), 'direction_id', 'descr');
        echo $form->field($model, 'direction_id')->dropDownList($directions, ['prompt'=>'Select...'])->label('Direction');
        ?>
        <?php if ( $model->isNewRecord ): ?>

            <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>

            <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>
        <?php endif; ?>


        <?php if ( User::hasPermission('bindUserToIp') ): ?>

            <?= $form->field($model, 'bind_to_ip')
                ->textInput(['maxlength' => 255])
                ->hint(UserManagementModule::t('back','For example: 123.34.56.78, 168.111.192.12')) ?>

        <?php endif; ?>

        <?php if ( User::hasPermission('editUserEmail') ): ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'email_confirmed')->checkbox() ?>

        <?php endif; ?>


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

<?php BootstrapSwitch::widget() ?>