<?php

use app\models\DaConfigs;
use app\models\LutDepartments;
use app\models\LutLocations;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use webvimark\extensions\BootstrapSwitch\BootstrapSwitch;

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
        $locations = ArrayHelper::map(LutLocations::find()->orderBy('name')->asArray()->all(), 'id', 'name');
        echo $form->field($model, 'location_id')->dropDownList($locations, ['prompt'=>'Select...'])->label('Location');
        $departments = ArrayHelper::map(LutDepartments::find()->orderBy('name')->asArray()->all(), 'id', 'name');
        echo $form->field($model, 'department_id')->dropDownList($departments, ['prompt'=>'Select...'])->label('Department');
        $configs = ArrayHelper::map(DaConfigs::find()->where(['status' => 1])->orderBy('name')->asArray()->all(), 'id', 'name');
        echo $form->field($model, 'config_id')->dropDownList($configs, ['prompt'=>'Select...'])->label('Report configuration');

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