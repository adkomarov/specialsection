<?php

//use AcceptanceTester;

use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Dataforms;


use yii\helpers\Url;
//use Codeception\Util\Assert;

use \Codeception\Util\Shared\Asserts;



class GrantsCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/specialsection/section/grants';

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
    
    public function testGrantsTextOnPage(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
    }


    public function submitValidData(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
        
        $textCommentDoc = 'Назначение докумета';
        $textUploadDoc = 'Документ для загрузки';

        $elementButtonSave = '#main > div > form > div.form-group > button:nth-child(1)';

        $test1='Приказ об установлении стипендий';
        
        $I->maximizeWindow();

        
        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/input[4]');
        $I->fillField(['xpath' => '/html/body/main/div/form/input[4]'], 'text1');
        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/input[8]');
        $I->fillField(['xpath' => '/html/body/main/div/form/input[8]'], 'text2');
        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/input[12]');
        $I->fillField(['xpath' => '/html/body/main/div/form/input[12]'], '3');
        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/input[16]');
        $I->fillField(['xpath' => '/html/body/main/div/form/input[16]'], '5');
        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/input[20]');
        $I->fillField(['xpath' => '/html/body/main/div/form/input[20]'], '4321');
        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/input[24]');
        $I->fillField(['xpath' => '/html/body/main/div/form/input[24]'], '1234');
        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/input[28]');
        $I->fillField(['xpath' => '/html/body/main/div/form/input[28]'], '321');
        $I->scrollToElementIfNotVisibleXpath('/html/body/main/div/form/input[32]');
        $I->fillField(['xpath' => '/html/body/main/div/form/input[32]'], '12');

        
        //$elementButtonAdd1 = '/html/body/main/div/form/div[1]/button';
        $elementTextInput1 = '/html/body/main/div/form/div[1]/div[1]/input';
        $elementFileUpload1 = '/html/body/main/div/form/div[1]/div[1]/div/input';
        $I->scrollToElementIfNotVisible('button.btn-success[value="10"]');
        $I->click('button.btn-success[value="10"]');
        $I->scrollToElementIfNotVisibleXpath($elementTextInput1);
        $I->fillField(['xpath' => $elementTextInput1], 'text1');
        $I->scrollToElementIfNotVisibleXpath($elementFileUpload1);
        $I->attachFile(['xpath' => $elementFileUpload1], 'test_copy_1.png');
        $I->scrollToElementIfNotVisible($elementButtonSave);
        $I->waitForElementClickable($elementButtonSave);
        $I->click($elementButtonSave);


        $elementButtonAdd2 = '/html/body/main/div/form/div[2]/button';
        $elementTextInput2 = '/html/body/main/div/form/div[1]/div[1]/input';
        $elementFileUpload2 = '/html/body/main/div/form/div[1]/div[1]/div/input';
        $I->scrollToElementIfNotVisible('button.btn-success[value="5"]');
        $I->click('button.btn-success[value="5"]');
        $I->scrollToElementIfNotVisibleXpath($elementTextInput2);
        $I->fillField(['xpath' => $elementTextInput2], 'text2');
        $I->scrollToElementIfNotVisibleXpath($elementFileUpload2);
        $I->attachFile(['xpath' => $elementFileUpload2], 'test_copy_2.png');

        $I->scrollToElementIfNotVisible($elementButtonSave);
        $I->waitForElementClickable($elementButtonSave);
        $I->click($elementButtonSave);

        /*

        //$I->scrollToElementIfNotVisible($elementButtonAdd2);
        //$I->click($elementButtonAdd2);
        //$I->scrollToElementIfNotVisible($elementButtonAdd1);
        //$I->click($elementButtonAdd1);
        $I->scrollToElementIfNotVisibleXpath($xpathDocSampleContract);
        $I->attachFile(['xpath' => $xpathDocSampleContract], 'test_copy_1.png');
        $I->scrollToElementIfNotVisibleXpath($xpathDocApprovalDocument);
        $I->attachFile(['xpath' => $xpathDocApprovalDocument], 'test_copy_2.png');
        $I->scrollToElementIfNotVisibleXpath($xpathDocDeliveryProcedure);
        $I->attachFile(['xpath' => $xpathDocDeliveryProcedure], 'test_copy_3.png');
        $I->scrollToElementIfNotVisibleXpath($xpathDocEstablishmentDocument);
        $I->attachFile(['xpath' => $xpathDocEstablishmentDocument], 'test_copy_4.png');

        $I->scrollToElementIfNotVisible($elementButtonSave);
        $I->click($elementButtonSave);

        $I->scrollToElementIfNotVisibleXpath($xpathTextSampleContract);
        $I->seeInField($xpathTextSampleContract,$textSampleContract1);
        $I->scrollToElementIfNotVisibleXpath($xpathTextApprovalDocument);
        $I->seeInField($xpathTextApprovalDocument,$textApprovalDocument1);
        $I->scrollToElementIfNotVisibleXpath($xpathTextDeliveryProcedure);
        $I->seeInField($xpathTextDeliveryProcedure,$textDeliveryProcedure1);
        $I->scrollToElementIfNotVisibleXpath($xpathTextEstablishmentDocument);
        $I->seeInField($xpathTextEstablishmentDocument,$textEstablishmentDocument1);

        


        $I->scrollToElementIfNotVisibleXpath($xpathTextSampleContract);
        $I->fillField(['xpath' => $xpathTextSampleContract], $textSampleContract2);
        $I->scrollToElementIfNotVisibleXpath($xpathTextApprovalDocument);
        $I->fillField(['xpath' => $xpathTextApprovalDocument], $textApprovalDocument2);
        $I->scrollToElementIfNotVisibleXpath($xpathTextDeliveryProcedure);
        $I->fillField(['xpath' => $xpathTextDeliveryProcedure], $textDeliveryProcedure2);
        $I->scrollToElementIfNotVisibleXpath($xpathTextEstablishmentDocument);
        $I->fillField(['xpath' => $xpathTextEstablishmentDocument], $textEstablishmentDocument2);


        $I->scrollToElementIfNotVisibleXpath($xpathDocSampleContract);
        $I->attachFile(['xpath' => $xpathDocSampleContract], 'test_copy_5.png');
        $I->scrollToElementIfNotVisibleXpath($xpathDocApprovalDocument);
        $I->attachFile(['xpath' => $xpathDocApprovalDocument], 'test_copy_6.png');
        $I->scrollToElementIfNotVisibleXpath($xpathDocDeliveryProcedure);
        $I->attachFile(['xpath' => $xpathDocDeliveryProcedure], 'test_copy_7.png');
        $I->scrollToElementIfNotVisibleXpath($xpathDocEstablishmentDocument);
        $I->attachFile(['xpath' => $xpathDocEstablishmentDocument], 'test_copy_8.png');

        $I->scrollToElementIfNotVisible($elementButtonSave);
        $I->click($elementButtonSave);

        $I->scrollToElementIfNotVisibleXpath($xpathTextSampleContract);
        $I->seeInField($xpathTextSampleContract,$textSampleContract2);
        $I->scrollToElementIfNotVisibleXpath($xpathTextApprovalDocument);
        $I->seeInField($xpathTextApprovalDocument,$textApprovalDocument2);
        $I->scrollToElementIfNotVisibleXpath($xpathTextDeliveryProcedure);
        $I->seeInField($xpathTextDeliveryProcedure,$textDeliveryProcedure2);
        $I->scrollToElementIfNotVisibleXpath($xpathTextEstablishmentDocument);
        $I->seeInField($xpathTextEstablishmentDocument,$textEstablishmentDocument2);
        */
    }
}