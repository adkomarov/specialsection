<?php

#use AcceptanceTester;
use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Fieldsforms;


use yii\helpers\Url;


class EdustandartsCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/specialsection/section/edustandarts';

    protected $tester;

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute($this->urlRoute));
        #    Dataforms::deleteAll();
    }

    protected function _after(AcceptanceTester $I)
    {
    }
    
    public function testDocumentAction(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
    }

    public function submitValidData(AcceptanceTester $I)
    {
        
        $xpathTextForm1 = '//*[@id="main"]/div/form/div[1]/div[1]/input';
        $xpathTextForm2 = '//*[@id="main"]/div/form/div[3]/div[1]/input';
        $xpathTextForm3 = '//*[@id="main"]/div/form/div[5]/div[1]/input';
        $xpathTextForm4 = '//*[@id="main"]/div/form/div[7]/div[1]/input';
        $xpathTextForms = [
            $xpathTextForm1,
            $xpathTextForm2,
            $xpathTextForm3,
            $xpathTextForm4,
        ];

        $textForm1 = 'textForm1';
        $textForm2 = 'textForm2';
        $textForm3 = 'textForm3';
        $textForm4 = 'textForm4';
        $textForms = [
            $textForm1,
            $textForm2,
            $textForm3,
            $textForm4,
        ];

        $xpathDocForm1 = '//*[@id="File0"]';
        $xpathDocForm2 = '//*[@id="File1"]';
        $xpathDocForm3 = '//*[@id="File2"]';
        $xpathDocForm4 = '//*[@id="File3"]';

        $xpathDocForms = [
            $xpathDocForm1,
            $xpathDocForm2,
            $xpathDocForm3,
            $xpathDocForm4,
        ];

        $testFile1 = 'test_copy_1.png';
        $testFile2 = 'test_copy_2.png'; 
        $testFile3 = 'test_copy_3.png'; 
        $testFile4 = 'test_copy_4.png'; 
        $testFiles = [
            $testFile1,
            $testFile2,
            $testFile3,
            $testFile4,
        ];

        $elementButtonAdd1 = 'button.btn-success[value="27"]';
        $elementButtonAdd2 = 'button.btn-success[value="28"]';
        $elementButtonAdd3 = 'button.btn-success[value="29"]';
        $elementButtonAdd4 = 'button.btn-success[value="30"]';

        $arrayElementsButtonsAdd = [
            $elementButtonAdd1,
            $elementButtonAdd2,
            $elementButtonAdd3,
            $elementButtonAdd4,

        ];

        $elementButtonSave = '#main > div > form > div.form-group > button:nth-child(1)';
        

        $I->maximizeWindow();
        $I->executeJS("document.querySelector('.navbar').style.display = 'none';");

        
        for ($i = 0; $i < count($arrayElementsButtonsAdd); $i++) {

            $button = $arrayElementsButtonsAdd[$i];
            
            $I->scrollToElementIfNotVisibleXpath($button);
            $I->wait(2);
            $I->click($button);
            $I->wait(2);
        }
        
        for ($i = 0; $i < count($xpathTextForms); $i++) {
            $oneOfXpathTextForms = $xpathTextForms[$i];
            $oneOftextForms = $textForms[$i];
        
            $I->scrollToElementIfNotVisibleXpath($oneOfXpathTextForms);
            $I->wait(2);
            $I->fillField(['xpath' => $oneOfXpathTextForms], $oneOftextForms);
            $I->wait(2);
        }
        
        for ($i = 0; $i < count($xpathDocForms); $i++) {
            $oneOfXpathDocForms = $xpathDocForms[$i];
            $oneOfTestFiles = $testFiles[$i];
        
            $I->scrollToElementIfNotVisibleXpath($oneOfXpathDocForms);
            $I->wait(2);
            $I->attachFile(['xpath' => $oneOfXpathDocForms], $oneOfTestFiles);
            $I->wait(2);
        }
        $I->scrollToElementIfNotVisible($elementButtonSave);
        $I->waitForElementClickable($elementButtonSave);
        $I->click($elementButtonSave);
    }
}