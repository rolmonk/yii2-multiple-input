<?php

use yii\bootstrap\ActiveForm;
use unclead\widgets\MultipleInput;
use unclead\widgets\examples\models\ExampleModel;
use yii\helpers\Html;
use unclead\widgets\MultipleInputColumn;

// Note: You have to install https://github.com/kartik-v/yii2-widget-datepicker for correct work an example
use kartik\date\DatePicker;

/* @var $this \yii\web\View */
/* @var $model ExampleModel */
?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation'      => true,
    'enableClientValidation'    => false,
    'validateOnChange'          => false,
    'validateOnSubmit'          => true,
    'validateOnBlur'            => false,
]);?>

<h3>Single column</h3>
<?php
    echo $form->field($model, 'emails')->widget(MultipleInput::className(), [
        'limit'             => 5,
        'allowEmptyList'    => true,
        'enableGuessTitle'  => true
    ])
    ->label(false);
?>

<h3>Multiple columns</h3>
<?= $form->field($model, 'schedule')->widget(MultipleInput::className(), [
    'limit' => 4,
    'allowEmptyList' => true,
    'columns' => [
        [
            'name'  => 'user_id',
            'type'  => MultipleInputColumn::TYPE_DROPDOWN,
            'enableError' => true,
            'title' => 'User',
            'defaultValue' => 33,
            /* it can be an anonymous function
            'items' => function($data) {
                return [
                    31 => 'item 31',
                    32 => 'item 32',
                    33 => 'item 33',
                    34 => 'item 34',
                    35 => 'item 35',
                    36 => 'item 36',
                ];
            }
            */
            'items' =>  [
                31 => 'item 31',
                32 => 'item 32',
                33 => 'item 33',
                34 => 'item 34',
                35 => 'item 35',
                36 => 'item 36',
            ]
        ],
        [
            'name'  => 'day',
            'type'  => DatePicker::className(),
            'title' => 'Day',
            'value' => function($data) {
                return $data['day'];
            },
            'items' => [
                '0' => 'Saturday',
                '1' => 'Monday'
            ],
            'options' => [
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'todayHighlight' => true
                ]
            ],
            'headerOptions' => [
                'style' => 'width: 250px;',
                'class' => 'day-css-class'
            ]
        ],
        [
            'name'  => 'priority',
            'title' => 'Priority',
            'defaultValue' => 1,
            'enableError' => true,
            'options' => [
                'class' => 'input-priority'
            ]
        ],
        [
            'name'  => 'comment',
            'type'  => MultipleInputColumn::TYPE_STATIC,
            'value' => function($data) {
                return Html::tag('span', 'static content', ['class' => 'label label-info']);
            },
            'headerOptions' => [
                'style' => 'width: 70px;',
            ]
        ],
        [
            'type' => MultipleInputColumn::TYPE_CHECKBOX_LIST,
            'name' => 'enable',
            'headerOptions' => [
                'style' => 'width: 80px;',
            ],
            'items' => [
                1 => 'Test 1',
                2 => 'Test 2',
                3 => 'Test 3',
                4 => 'Test 4'
            ],
            'options' => [
                // see checkboxList implementation in the BaseHtml helper for getting more detail
                'unselect' => 2
            ]
        ]
    ]
]);
?>

<?= Html::submitButton('Update', ['class' => 'btn btn-success']);?>
<?php ActiveForm::end();?>


<?php
$js = <<< JS
        $('#examplemodel-schedule').on('afterInit', function(){
            console.log('calls on after initialization event');
        }).on('beforeAddRow', function(e) {
            console.log('calls on before add row event');
        }).on('afterAddRow', function(e) {
            console.log('calls on after add row event');
        }).on('beforeDeleteRow', function(e, item){
            console.log(item);
            console.log('calls on before remove row event');
            return confirm('Are you sure you want to delete row?')
        }).on('afterDeleteRow', function(){
            console.log('calls on after remove row event');
        });
JS;

$this->registerJs($js);