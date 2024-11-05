<?php
use yii\helpers\Html;
/** @var yii\web\View $this */
use app\modules\specialsection\assets\AppAsset;
use app\modules\specialsection\widgets\MenuSectionsWidget;
AppAsset::register($this);
$this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
$this->registerCssFile('@module_specialsection_css/styles.css');
?>
<h3 style="font-size:medium"><b>Выберите подраздел</h3>

<?php

echo MenuSectionsWidget::widget(['type' => MenuSectionsWidget::TYPE_LIST,'items'=> $menuItems]);

?>