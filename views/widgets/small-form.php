<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\form\ActiveForm;
?>
<div class="user-purse-small-refill">
    <h4>
        <?= Yii::t('user-purse', 'Amount'); ?>
        <?= $purse->amount; ?>
    </h4>
    <?php
    $form = ActiveForm::begin([
                'action' => Url::toRoute(['/user-purse/front/refill']),
                'id' => 'form-refill-small',
                'method'=> 'GET'
    ]);
    ?>
    <?=
    $form->field($formRefill, 'amount', [
        'template' => '{input}{hint}{error}'
    ]);
    ?>
    <?= Html::submitButton(Yii::t('user-purse', 'Refill'), ['class' => 'btn btn-success btn-save']); ?>
    <?php
    ActiveForm::end();
    ?>
</div>