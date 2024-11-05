<?php

#use AcceptanceTester;
use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Fieldsforms;


use yii\helpers\Url;


class EducationCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/specialsection/section/education';

    protected $tester;

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute($this->urlRoute));//'/takedatam/default/paidedu'
    }

    #protected function _before(AcceptanceTester $I)
    #{
    #    Dataforms::deleteAll();
    #}

    protected function _after(AcceptanceTester $I)
    {
    }
    
    public function testEducationAction(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
        //$I->see('Home');
    }

    public function submitValidData(AcceptanceTester $I)
    {
        $textCodename = '11111';
        $textNameProfession = 'Прикладная информатика';
        $textEducationalCode = '09.03.03';
        $textNumberGraduates = '20';
        $textNumberEmployed = '10';

        $xpathCodename = '/html/body/main/div/form/div[9]/div[1]/input[2]';
        $xpathNameProfession = '/html/body/main/div/form/div[9]/div[2]/input[2]';
        $xpathEducationalCode = '/html/body/main/div/form/div[9]/div[3]/input[2]';
        $xpathNumberGraduates = '/html/body/main/div/form/div[9]/div[4]/input[2]';
        $xpathumberEmployed = '/html/body/main/div/form/div[9]/div[5]/input[2]';

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

        $elementButtonAdd1 = '/html/body/main/div/form/div[1]/button';
        $elementButtonAdd2 = '/html/body/main/div/form/div[3]/button';
        $elementButtonAdd3 = '/html/body/main/div/form/div[5]/button';
        $elementButtonAdd4 = '/html/body/main/div/form/div[7]/button';
        $elementButtonAdd5 = '/html/body/main/div/form/div[9]/button';
        $arrayElementsButtonsAdd = [
            $elementButtonAdd1,
            $elementButtonAdd2,
            $elementButtonAdd3,
            $elementButtonAdd4,
            $elementButtonAdd5,
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



        $I->scrollToElementIfNotVisibleXpath($xpathCodename);
        $I->fillField(['xpath' => $xpathCodename], $textCodename);

        $I->scrollToElementIfNotVisibleXpath($xpathNameProfession);
        $I->fillField(['xpath' => $xpathNameProfession], $textNameProfession);

        $I->scrollToElementIfNotVisibleXpath($xpathEducationalCode);
        $I->fillField(['xpath' => $xpathEducationalCode], $textEducationalCode);

        $I->scrollToElementIfNotVisibleXpath($xpathNumberGraduates);
        $I->fillField(['xpath' => $xpathNumberGraduates], $textNumberGraduates);

        $I->scrollToElementIfNotVisibleXpath($xpathumberEmployed);
        $I->fillField(['xpath' => $xpathumberEmployed], $textNumberEmployed);

        
        $I->scrollToElementIfNotVisible($elementButtonSave);
        $I->waitForElementClickable($elementButtonSave);
        $I->click($elementButtonSave);

    }
}