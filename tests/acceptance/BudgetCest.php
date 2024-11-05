<?php

//use AcceptanceTester;

use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Dataforms;


use yii\helpers\Url;
//use Codeception\Util\Assert;

use \Codeception\Util\Shared\Asserts;



class BudgetCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/specialsection/section/budget';

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

    public function testBudgetAction(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
    }


    public function submitValidData(AcceptanceTester $I)
    {
        $textField0 = '0000';
        $textField1 = '1111';
        $textField2 = '2222';
        $textField3 = '3333';

        $textFieldYear0 = '2024';
        $textFieldYear1 = '2025';

        $textFieldPlusSum0 = '8';
        $textFieldPlusSum1 = '7';

        $textFieldMinusSum0 = '6';
        $textFieldMinusSum1 = '5';

        $textFieldAddPlan = 'test1';
        $textFieldBusGov = 'test2';

        $testFile1 = 'test_copy_1.png';
        $testUrl2 = 'https://www.deepl.com/ru/translator'; 

        $xpathInputTextTest0 = '/html/body/main/div/form/input[4]';
        $xpathInputTextTest1 = '/html/body/main/div/form/input[8]';
        $xpathInputTextTest2 = '/html/body/main/div/form/input[12]';
        $xpathInputTextTest3 = '/html/body/main/div/form/input[16]';


        $xpathButtonAddYearPay0 = '/html/body/main/div/form/div[1]/button';
        $xpathButtonAddYearPay1 = '/html/body/main/div/form/div[2]/button';

        $xpathYearInput0 = '/html/body/main/div/form/div[1]/div[1]/input';
        $xpathYearInput1 = '/html/body/main/div/form/div[2]/div[1]/input';

        $xpathPlusSum0 = '/html/body/main/div/form/div[1]/div[2]/input[2]';
        $xpathPlusSum1 = '/html/body/main/div/form/div[2]/div[2]/input[2]';

        $xpathMinusSum0 = '/html/body/main/div/form/div[1]/div[3]/input[2]';
        $xpathMinusSum1 = '/html/body/main/div/form/div[2]/div[3]/input[2]';

        $xpathButtonAddPlan = '/html/body/main/div/form/div[4]/button';
        $xpathButtonAddBusGov = '/html/body/main/div/form/div[6]/button';

        $xpathInputTextAddPlan = '/html/body/main/div/form/div[4]/div[1]/input';
        $xpathInputFileAddPlan = '/html/body/main/div/form/div[4]/div[1]/div/input';

        $xpathInputTextBusGov = '/html/body/main/div/form/div[6]/div[1]/input[1]';
        $xpathInputFileBusGov = '//html/body/main/div/form/div[6]/div[1]/input[2]';

        $xpathButtonSave = '/html/body/main/div/form/div[8]/button';

        $I->scrollToElementIfNotVisibleXpath($xpathButtonAddYearPay0);
        $I->click($xpathButtonAddYearPay0);

        $I->scrollToElementIfNotVisibleXpath($xpathButtonAddYearPay1);
        $I->click($xpathButtonAddYearPay1);

        $I->scrollToElementIfNotVisibleXpath($xpathButtonAddPlan);
        $I->click($xpathButtonAddPlan);

        $I->scrollToElementIfNotVisibleXpath($xpathButtonAddBusGov);
        $I->click($xpathButtonAddBusGov);

        $I->scrollToElementIfNotVisibleXpath($xpathInputTextTest0);
        $I->fillField(['xpath' => $xpathInputTextTest0], $textField0);

        $I->scrollToElementIfNotVisibleXpath($xpathInputTextTest1);
        $I->fillField(['xpath' => $xpathInputTextTest1], $textField1);

        $I->scrollToElementIfNotVisibleXpath($xpathInputTextTest2);
        $I->fillField(['xpath' => $xpathInputTextTest2], $textField2);

        $I->scrollToElementIfNotVisibleXpath($xpathInputTextTest3);
        $I->fillField(['xpath' => $xpathInputTextTest3], $textField3);

        $I->scrollToElementIfNotVisibleXpath($xpathYearInput0);
        $I->fillField(['xpath' => $xpathYearInput0], $textFieldYear0);

        $I->scrollToElementIfNotVisibleXpath($xpathYearInput1);
        $I->fillField(['xpath' => $xpathYearInput1], $textFieldYear1);

        $I->scrollToElementIfNotVisibleXpath($xpathPlusSum0);
        $I->fillField(['xpath' => $xpathPlusSum0], $textFieldPlusSum0);

        $I->scrollToElementIfNotVisibleXpath($xpathPlusSum1);
        $I->fillField(['xpath' => $xpathPlusSum1], $textFieldPlusSum1);

        $I->scrollToElementIfNotVisibleXpath($xpathMinusSum0);
        $I->fillField(['xpath' => $xpathMinusSum0], $textFieldMinusSum0);

        $I->scrollToElementIfNotVisibleXpath($xpathMinusSum1);
        $I->fillField(['xpath' => $xpathMinusSum1], $textFieldMinusSum1);

        $I->scrollToElementIfNotVisibleXpath($xpathInputTextAddPlan);
        $I->fillField(['xpath' => $xpathInputTextAddPlan], $textFieldAddPlan);

        $I->scrollToElementIfNotVisibleXpath($xpathInputTextBusGov);
        $I->fillField(['xpath' => $xpathInputTextBusGov], $textFieldBusGov);

        $I->scrollToElementIfNotVisibleXpath($xpathInputFileAddPlan);
        $I->attachFile(['xpath' => $xpathInputFileAddPlan], $testFile1);

        $I->scrollToElementIfNotVisibleXpath($xpathInputFileBusGov);
        $I->fillField(['xpath' => $xpathInputFileBusGov], $testUrl2);

        $I->scrollToElementIfNotVisibleXpath($xpathButtonSave);
        $I->click($xpathButtonSave);
    }

}
    /*

$xpathTestNameForUrl1 = '//*[@id="main"]/div/form/div[1]/div[1]/input[1]';
$xpathTestUrl1 = '//*[@id="main"]/div/form/div[1]/div[1]/input[2]';
$xpathTestNameForUrl2 = '//*[@id="main"]/div/form/div[3]/div[1]/input[1]';
$xpathTestUrl2 = '//*[@id="main"]/div/form/div[3]/div[1]/input[2]';

$testNameForUrl1 = 'php-webdriver';
$testUrl1 = 'https://github.com/php-webdriver/php-webdriver?tab=readme-ov-file';
$testNameForUrl2 = 'ai deepseek';
$testUrl2 = 'https://chat.deepseek.com/coder';
$testNameForUrl3 = 'deepl translate';
$testUrl3 = 'https://www.deepl.com/ru/translator';

$textNameForUrl = 'Название для ссылки';
$textUrl = 'Ссылка';

$elementButtonSave = '#main > div > form > div.form-group > button:nth-child(1)';

$listXpath = [$xpathTestNameForUrl1,$xpathTestUrl1,$xpathTestNameForUrl2,$xpathTestUrl2,$elementButtonSave];
$uniqueListXpath = array_unique($listXpath);
Assert::assertSame(count($listXpath), count($uniqueListXpath), "Список содержит повторяющиеся значения.");

$listName = [$testNameForUrl1,$testNameForUrl2,$testNameForUrl3];
$uniqueListName = array_unique($listName);
Assert::assertSame(count($listName), count($uniqueListName), "Список содержит повторяющиеся значения.");

$listUrl = [$testUrl1,$testUrl2,$testUrl3];
$uniqueListUrl = array_unique($listUrl);
Assert::assertSame(count($listUrl), count($uniqueListUrl), "Список содержит повторяющиеся значения.");


//данные на странице отсутствуют
//$I->isElementNotVisible('#main > div > form > div:nth-child(3) > div.col-sm-11 > label:nth-child(1)');
//$I->isElementNotVisible('#main > div > form > div:nth-child(3) > div.col-sm-11 > label:nth-child(4)');
//$I->dontSee($textNameForUrl);
//$I->dontSee($textUrl);

$I->dontSeeElement(['xpath'=>$xpathTestNameForUrl1]);
$I->dontSeeElement(['xpath'=>$xpathTestUrl1]);
$I->dontSeeElement(['xpath'=>$xpathTestNameForUrl2]);
$I->dontSeeElement(['xpath'=>$xpathTestUrl2]);


//вызов формы
$buttons = $I->grabMultiple('button#add_row');
$I->click(['css' => 'button#add_row:nth-of-type(1)']);
//внесли данные 1
$I->fillField(['xpath' => $xpathTestNameForUrl1], $testNameForUrl1);
$I->fillField(['xpath' => $xpathTestUrl1], $testUrl1);
$I->scrollToElementIfNotVisible($elementButtonSave);
$I->click($elementButtonSave);
$I->wait(1);


//мы на странице и видим данные 1
$I->amOnPage($this->urlRoute);
//$I->isElementVisible('#main > div > form > div:nth-child(3) > div.col-sm-11 > label:nth-child(1)');
//$I->isElementVisible('#main > div > form > div:nth-child(3) > div.col-sm-11 > label:nth-child(4)');

$I->seeInField($xpathTestNameForUrl1,$testNameForUrl1);
$I->seeInField($xpathTestUrl1,$testUrl1);
//2 и 3 часть не внесена
$I->dontSeeElement(['xpath'=>$xpathTestNameForUrl2]);
$I->dontSeeElement(['xpath'=>$xpathTestUrl2]);


//вызов формы
$buttons = $I->grabMultiple('button#add_row');
$I->click(['xpath' => '/html/body/main/div/form/div[3]/button']);
//внесли данные 2
$I->fillField(['xpath' => $xpathTestNameForUrl2], $testNameForUrl2);
$I->fillField(['xpath' => $xpathTestUrl2], $testUrl2);
$I->scrollToElementIfNotVisible($elementButtonSave);
$I->click($elementButtonSave);


//мы на странице и видим данные
$I->amOnPage($this->urlRoute);
//$I->see($textNameForUrl);
//$I->see($textUrl);

$I->seeInField($xpathTestNameForUrl1,$testNameForUrl1);
$I->seeInField($xpathTestUrl1,$testUrl1);
$I->seeInField($xpathTestNameForUrl2,$testNameForUrl2);
$I->seeInField($xpathTestUrl2,$testUrl2);


//3 часть не внесена в поля 2
#Assert::assertEquals('expected', 'actual');
$actualValue = $I->grabValueFrom(['xpath' => $xpathTestNameForUrl2]);
Assert::assertNotEquals($actualValue,$testNameForUrl3);
$actualValue = $I->grabValueFrom(['xpath' => $xpathTestUrl2]);
Assert::assertNotEquals($actualValue,$testUrl3);


//обновляем данные 2 на 3
$I->fillField(['xpath' => $xpathTestNameForUrl2], $testNameForUrl3);
$I->fillField(['xpath' => $xpathTestUrl2], $testUrl3);
$I->scrollToElementIfNotVisible($elementButtonSave);
$I->click($elementButtonSave);


//мы на странице и видим данные 1 и 3
$I->amOnPage($this->urlRoute);
//$I->see($textNameForUrl);
//$I->see($textUrl);

$I->seeInField($xpathTestNameForUrl1,$testNameForUrl1);
$I->seeInField($xpathTestUrl1,$testUrl1);
$I->seeInField($xpathTestNameForUrl2,$testNameForUrl3);
$I->seeInField($xpathTestUrl2,$testUrl3);
//2 часть не внесена
$actualValue = $I->grabValueFrom(['xpath' => $xpathTestNameForUrl2]);
Assert::assertNotEquals($actualValue,$testNameForUrl2);
$actualValue = $I->grabValueFrom(['xpath' => $xpathTestUrl2]);
Assert::assertNotEquals($actualValue,$testUrl2);
*/
    //*[@id="main"]/div/form/div[1]/div[1]/input[1]
    ////div[@class="row oform_row" and @value="0"]//input[@type="text" and @name="paid_educational[0][]"]'
    //*[@id="main"]/div/form/div[1]/div[1]/input[2]
    ////div[@class="row oform_row" and @value="0"]//input[@type="url" and @name="paid_educational[0][]"]
    //php-webdriver
    //https://github.com/php-webdriver/php-webdriver?tab=readme-ov-file
    //yii2 installation
    //https://www.yiiframework.com/doc/guide/2.0/ru/start-installation
    //config
    //https://stackoverflow.com/questions/58234712/yii2-module-is-not-configured-options-configfile-are-required-error-codece
    //WebDriver-Chrome
    //https://codeception.com/docs/modules/WebDriver#.VwOm6xN96Rs
    //$I->scrollTo('#main > div > form > div.form-group > button:nth-child(1)');
    //$I->scrollTo('#main > div > form > div.form-group > button:nth-child(1)');





    /*
    public function customScrollTo($elementButtonSave, $maxAttempts = 10, AcceptanceTester $I){

        function isElementVisible($I, $selector) {
            return $I->executeJS("return document.querySelector('$selector').getBoundingClientRect().top < window.innerHeight;");
        }
        $attempt = 0;

        while (!isElementVisible($I, $elementButtonSave) && $attempt < $maxAttempts) {
            $I->scrollTo($elementButtonSave);
            $attempt++;
        }
    }
    */
    /*
        function isElementVisible($I, $selector) {
            return $I->executeJS("return document.querySelector('$selector').getBoundingClientRect().top < window.innerHeight;");
        }
        $attempt = 0;
        $maxAttempts = 10;

        while (!isElementVisible($I, $elementButtonSave) && $attempt < $maxAttempts) {
            $I->scrollTo($elementButtonSave);
            $attempt++;
        }
    */

    // Function to check if the element is visible
    //$this->customScrollTo($elementButtonSave);
    //customScrollTo($elementButtonSave);

    // Final check to ensure element is visible
    //$I->isElementVisible($I, $elementButtonSave);

    // Click the button

    //$buttons = $I->grabMultiple('button#add_row');

    //$I->click(['css' => 'button#add_row:nth-of-type(1)']);
    //$I->click('//*[@id="main"]/div/form/div[5]/button[1]');
    /*
    $I->submitForm('row oform_row', [
        'paid_educational[0][2]' => 'yii2 installation',
        'paid_educational[0][3]' => 'https://www.yiiframework.com/doc/guide/2.0/ru/start-installation',
    ]);
    //$I->seeInCurrentUrl('/controller-name/paidedu');
    
    $I->dontSee('Проверьте правильность введенных данных.', '.alert-error');
    */
    /*
    $I->seeInDatabase('dataforms', [
        'variable' => '1',
        'namefildsforms' => 'Field Name 1',
        'datafilds' => 'Field Data 1'
    ]);
    */
    /*
    $I->submitForm('row oform_row', [
        'paid_educational[0][0]' => 'php-webdriver',
        'paid_educational[0][1]' => 'https://github.com/php-webdriver/php-webdriver?tab=readme-ov-file',
    ]);
    */
    /*
    $buttons = $I->grabMultiple('button#add_row');
    $I->click(['css' => 'button#add_row:nth-of-type(1)']);
    */

    /*
    public function submitInvalidData(AcceptanceTester $I)
    {
        $I->amOnPage('/controller-name/paidedu');
        
        // Simulate filling the form with invalid data (empty data field)
        $I->submitForm('#paid-edu-form', [
            'paid_educational[0][0]' => '0', // New record
            'paid_educational[0][1]' => '1',
            'paid_educational[0][2]' => 'Field Name 1',
            'paid_educational[0][3]' => '',
        ]);

        // Ensure redirect happens
        $I->seeInCurrentUrl('/controller-name/paidedu');

        // Ensure error flash message is set
        $I->see('Проверьте правильность введенных данных.', '.alert-error');

        // Ensure the wrong data session variable is set correctly
        $wrongData = [
            [
                "namefildsforms" => 'Field Name 1',
                "iddataforms" => 0,
                "datafilds" => 'Введите данные',
                "variable" => '1'
            ]
        ];
        $I->seeInSession('wrong_data', $wrongData);
    }

    public function submitUpdateExistingData(AcceptanceTester $I)
    {
        // Assuming there is a record in the database to update
        $existingRecordId = $I->grabFromDatabase('dataforms', 'iddataforms', ['namefildsforms' => 'Existing Field']);
        
        $I->amOnPage('/controller-name/paidedu');

        // Simulate filling the form with data to update an existing record
        $I->submitForm('#paid-edu-form', [
            'paid_educational[0][0]' => $existingRecordId, // Existing record ID
            'paid_educational[0][1]' => '1',
            'paid_educational[0][2]' => 'Updated Field Name',
            'paid_educational[0][3]' => 'Updated Field Data',
        ]);

        // Ensure redirect happens
        $I->seeInCurrentUrl('/controller-name/paidedu');

        // Ensure no error flash message is set
        $I->dontSee('Проверьте правильность введенных данных.', '.alert-error');

        // Ensure data is updated correctly
        $I->seeInDatabase('dataforms', [
            'iddataforms' => $existingRecordId,
            'namefildsforms' => 'Updated Field Name',
            'datafilds' => 'Updated Field Data'
        ]);
    }
    */
