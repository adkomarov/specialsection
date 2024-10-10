<?php

namespace app\modules\specialsection;


use Yii\base\BootstrapInterface;
/**
 * newmodules module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\specialsection\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->params = require __DIR__ . '/config/params.php';
        \Yii::setAlias('@module_specialsection_root', '@app/modules/specialsection/public');
        \Yii::setAlias('@module_specialsection_root_public', '@app/modules/specialsection/public');
        $assetManager = \Yii::$app->assetManager;
        $publishedUrl = $assetManager->getPublishedUrl('@app/modules/specialsection/public');
        \Yii::setAlias('@module_specialsection_js', $publishedUrl . '/js');
        \Yii::setAlias('@module_specialsection_css', $publishedUrl . '/css');
        // custom initialization code goes here
    }
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            '/delete_paid_edu'                                         => 'specialsection/section/deletepaidedu',
            '/delete_grants'                                           => 'specialsection/section/deletegrants',
            '/delete_document'                                         => 'specialsection/section/deletedocument',
            '/delete_inter'                                            => 'specialsection/section/deleteinter',
            '/delete_budget'                                           => 'specialsection/section/deletebudget',
            '/delete_objects'                                          => 'specialsection/section/deleteobjects',
            ], false);
    }
}