<?php

//use AcceptanceTester;

use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Dataforms;


use yii\helpers\Url;
//use Codeception\Util\Assert;

use \Codeception\Util\Shared\Asserts;



class CommonCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/specialsection/section/common';

    protected $tester;

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute($this->urlRoute));
    }

    #protected function _before(AcceptanceTester $I)
    #{
    #    Dataforms::deleteAll();
    #}

    protected function _after(AcceptanceTester $I)
    {
    }

    public function testCommonTextOnPage(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
    }


    public function submitValidData(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);

        $textCommentDoc = 'Назначение докумета';
        $textUploadDoc = 'Документ для загрузки';

        $elementButtonSave = '#main > div > form > div.form-group > button:nth-child(1)';

        $test1 = 'Приказ об установлении стипендий';

        $I->maximizeWindow();


        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/div[1]/div[1]/input');
        $I->fillField(['xpath' => '/html/body/main/div/form/div[1]/div[1]/input'], 'text1');

        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/div[1]/div[2]/input');
        $I->fillField(['xpath' => '/html/body/main/div/form/div[1]/div[2]/input'], 'text2');

        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/div[1]/div[3]/input');
        $I->fillField(['xpath' => '/html/body/main/div/form/div[1]/div[3]/input'], 'dded');

        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/div[1]/div[4]/input');
        $I->fillField(['xpath' => '/html/body/main/div/form/div[1]/div[4]/input'], 'test@mail.ru');

        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/div[1]/div[5]/input');
        $I->fillField(['xpath' => '/html/body/main/div/form/div[1]/div[5]/input'], 'http://127.0.0.1:9001/browser');

        $elementTextInput1 = '/html/body/main/div/form/div[2]/div[1]/input';
        $elementFileUpload1 = '/html/body/main/div/form/div[2]/div[1]/div/input';
        $I->scrollToElementIfNotVisible('button.btn-success[value="25"]');
        $I->click('button.btn-success[value="25"]');
        $I->scrollToElementIfNotVisibleXpath($elementTextInput1);
        $I->fillField(['xpath' => $elementTextInput1], 'text1');
        $I->scrollToElementIfNotVisibleXpath($elementFileUpload1);
        $I->attachFile(['xpath' => $elementFileUpload1], 'test_copy_1.png');

        $elementTextInput2 = '/html/body/main/div/form/div[4]/div[1]/input';
        $elementFileUpload2 = '/html/body/main/div/form/div[4]/div[1]/div/input';
        $I->scrollToElementIfNotVisible('button.btn-success[value="26"]');
        $I->click('button.btn-success[value="26"]');
        $I->scrollToElementIfNotVisibleXpath($elementTextInput2);
        $I->fillField(['xpath' => $elementTextInput2], 'text2');
        $I->scrollToElementIfNotVisibleXpath($elementFileUpload2);
        $I->attachFile(['xpath' => $elementFileUpload2], 'test_copy_2.png');

        $I->wait(10);
        $I->scrollToElementIfNotVisible($elementButtonSave);
        $I->waitForElementClickable($elementButtonSave);
        $I->click($elementButtonSave);

    }
}