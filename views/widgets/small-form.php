<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\form\ActiveForm;
?>
<div class="user-purse-small-refill">
    <h4>
        <?= $purse->amount; ?>
    </h4>
    <?php
    $form = ActiveForm::begin([
                'action' => Url::toRoute(['/user-purse/front/refill']),
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'formConfig' => ['labelSpan' => 0],
                'id' => 'form-refill-small'
    ]);
    ?>
    <?=
    $form->field($formRefill, 'amount', [
        'template' => '{input}{hint}{error}'
    ]);
    ?>
    <?= Html::submitButton(Yii::t('user-purse', 'Save'), ['class' => 'btn btn-success btn-save']); ?>
    <?php
    ActiveForm::end();
    ?>
</div>