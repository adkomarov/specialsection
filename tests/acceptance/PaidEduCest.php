<?php

//use AcceptanceTester;

use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Dataforms;


use yii\helpers\Url;
//use Codeception\Util\Assert;

use \Codeception\Util\Shared\Asserts;



class PaidEduCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/specialsection/section/paidedu';

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
    
    public function testPaidEduTextOnPage(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
        $I->see('Образовательные стандарты и требования');
        $I->see('Образец договора об оказании платных образовательных услуг');
        $I->see('Документ об утверждении стоимости обучения по каждой образовательной программе в виде электронного документа, подписанного электронной подписью');
        $I->see('Порядок оказания платных образовательных услуг в виде электронного документа, подписанного электронной подписью');
        $I->see('Документ об установлении размера платы, взимаемой с родителей (законных представителей) за присмотр и уход за детьми, осваивающими образовательные программы дошкольного образования в организациях, осуществляющих образовательную деятельность, за содержание детей в образовательной организации, реализующей образовательные программы начального общего, основного общего или среднего общего образования, если в такой образовательной организации созданы условия для проживания обучающихся в интернате, либо за осуществление присмотра и ухода за детьми в группах продленного дня в образовательной организации, реализующей образовательные программы начального общего, основного общего или среднего общего образования в виде электронного документа, подписанного электронной подписью');
    }


    public function submitValidData(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);

        $xpathTextSampleContract = '//*[@id="main"]/div/form/div[1]/div[1]/input';
        $xpathDocSampleContract = '//*[@id="File0"]';

        $xpathTextApprovalDocument = '//*[@id="main"]/div/form/div[3]/div[1]/input';
        $xpathDocApprovalDocument  = '//*[@id="File1"]';

        $xpathTextDeliveryProcedure = '//*[@id="main"]/div/form/div[5]/div[1]/input';
        $xpathDocDeliveryProcedure = '//*[@id="File2"]';

        $xpathTextEstablishmentDocument = '//*[@id="main"]/div/form/div[7]/div[1]/input';
        $xpathDocEstablishmentDocument = '//*[@id="File3"]';

        $elementButtonAdd1 = '/html/body/main/div/form/div[1]/button';
        $elementButtonAdd2 = '/html/body/main/div/form/div[2]/button';
        $elementButtonAdd3 = '/html/body/main/div/form/div[3]/button';
        $elementButtonAdd4 = '/html/body/main/div/form/div[4]/button';

        $elementButtonDel1 = '/html/body/main/div/form/div[1]/div[2]/button';
        $elementButtonDel2 = '/html/body/main/div/form/div[2]/div[2]/button';
        $elementButtonDel3 = '/html/body/main/div/form/div[3]/div[2]/button';
        $elementButtonDel4 = '/html/body/main/div/form/div[4]/div[2]/button';
        
        $textSampleContract1 = 'Образец договора об оказании платных образовательных услуг (версия 1)';
        $textApprovalDocument1 = 'Документ об утверждении стоимости обучения по каждой образовательной программе в виде электронного документа, подписанного электронной подписью (версия 1)';
        $textDeliveryProcedure1 = 'Порядок оказания платных образовательных услуг в виде электронного документа, подписанного электронной подписью (версия 1)';
        $textEstablishmentDocument1 = 'Документ об установлении размера платы, взимаемой с родителей (законных представителей) за присмотр и уход за детьми, осваивающими образовательные программы дошкольного образования в организациях, осуществляющих образовательную деятельность, за содержание детей в образовательной организации, реализующей образовательные программы начального общего, основного общего или среднего общего образования, если в такой образовательной организации созданы условия для проживания обучающихся в интернате, либо за осуществление присмотра и ухода за детьми в группах продленного дня в образовательной организации, реализующей образовательные программы начального общего, основного общего или среднего общего образования в виде электронного документа, подписанного электронной подписью (версия 1)';
        
        $textSampleContract2 = 'Образец договора об оказании платных образовательных услуг (версия 2)';
        $textApprovalDocument2 = 'Документ об утверждении стоимости обучения по каждой образовательной программе в виде электронного документа, подписанного электронной подписью (версия 2)';
        $textDeliveryProcedure2 = 'Порядок оказания платных образовательных услуг в виде электронного документа, подписанного электронной подписью (версия 2)';
        $textEstablishmentDocument2 = 'Документ об установлении размера платы, взимаемой с родителей (законных представителей) за присмотр и уход за детьми, осваивающими образовательные программы дошкольного образования в организациях, осуществляющих образовательную деятельность, за содержание детей в образовательной организации, реализующей образовательные программы начального общего, основного общего или среднего общего образования, если в такой образовательной организации созданы условия для проживания обучающихся в интернате, либо за осуществление присмотра и ухода за детьми в группах продленного дня в образовательной организации, реализующей образовательные программы начального общего, основного общего или среднего общего образования в виде электронного документа, подписанного электронной подписью (версия 2)';
        
        $textCommentDoc = 'Назначение докумета';
        $textUploadDoc = 'Документ для загрузки';

        $elementButtonSave = '/html/body/main/div/form/div[9]/button';
        
        $listXpath = [
            $xpathTextSampleContract,
            $xpathDocSampleContract,
            $xpathTextApprovalDocument,
            $xpathDocApprovalDocument,
            $xpathTextDeliveryProcedure,
            $xpathDocDeliveryProcedure,
            $xpathTextEstablishmentDocument,
            $xpathDocEstablishmentDocument,
            $textSampleContract1,
            $textApprovalDocument1,
            $textDeliveryProcedure1,
            $textEstablishmentDocument1,
            $textSampleContract2,
            $textApprovalDocument2,
            $textDeliveryProcedure2,
            $textEstablishmentDocument2,
            $textCommentDoc,
            $textUploadDoc,
            $elementButtonSave];
        $uniqueListXpath = array_unique($listXpath);
        Assert::assertSame(count($listXpath), count($uniqueListXpath), "Список содержит повторяющиеся значения.");



        $I->maximizeWindow();
        $I->scrollToElementIfNotVisible('button.btn-success[value="1"]');
        $I->click('button.btn-success[value="1"]');
        $I->scrollToElementIfNotVisible('button.btn-success[value="2"]');
        $I->click('button.btn-success[value="2"]');
        $I->scrollToElementIfNotVisible('button.btn-success[value="3"]');
        $I->click('button.btn-success[value="3"]');
        //$I->scrollTo('button.btn-success[value="4"]');
        $I->scrollToElementIfNotVisible('button.btn-success[value="4"]');
        $I->click('button.btn-success[value="4"]');
        
        
        $I->scrollToElementIfNotVisibleXpath($xpathTextSampleContract);
        $I->fillField(['xpath' => $xpathTextSampleContract], $textSampleContract1);
        $I->scrollToElementIfNotVisibleXpath($xpathTextApprovalDocument);
        $I->fillField(['xpath' => $xpathTextApprovalDocument], $textApprovalDocument1);
        $I->scrollToElementIfNotVisibleXpath($xpathTextDeliveryProcedure);
        $I->fillField(['xpath' => $xpathTextDeliveryProcedure], $textDeliveryProcedure1);
        $I->scrollToElementIfNotVisibleXpath($xpathTextEstablishmentDocument);
        $I->fillField(['xpath' => $xpathTextEstablishmentDocument], $textEstablishmentDocument1);

        $I->scrollToElementIfNotVisibleXpath($xpathDocSampleContract);
        $I->attachFile(['xpath' => $xpathDocSampleContract], 'test_copy_1.png');
        $I->scrollToElementIfNotVisibleXpath($xpathDocApprovalDocument);
        $I->attachFile(['xpath' => $xpathDocApprovalDocument], 'test_copy_2.png');
        $I->scrollToElementIfNotVisibleXpath($xpathDocDeliveryProcedure);
        $I->attachFile(['xpath' => $xpathDocDeliveryProcedure], 'test_copy_3.png');
        $I->scrollToElementIfNotVisibleXpath($xpathDocEstablishmentDocument);
        $I->attachFile(['xpath' => $xpathDocEstablishmentDocument], 'test_copy_4.png');

        $I->scrollToElementIfNotVisibleXpath($elementButtonSave);
        $I->click($elementButtonSave);
        /*
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

        // TODO: deleting files, now some item is overriding the delete button.
        /*
        $I->scrollTo("(//button[contains(@class, 'btn') and contains(@class, 'btn-danger') and contains(@class, 'delbutton')])[2]");
        $I->waitForElementClickable("(//button[contains(@class, 'btn') and contains(@class, 'btn-danger') and contains(@class, 'delbutton')])[2]");
        $I->click("(//button[contains(@class, 'btn') and contains(@class, 'btn-danger') and contains(@class, 'delbutton')])[2]");
        $I->acceptPopup();
        */
        /*
        Test  tests/acceptance/PaidEduCest.php:submitValidData
        [Facebook\WebDriver\Exception\ElementClickInterceptedException] element click intercepted: Element <button type="button" id="delrow" class="btn btn-danger delbutton" tabindex="-1" value="/delete_document">...</button> is not clickable at point (321, 19). Other element would receive the click: <a class="navbar-brand" href="/">...</a>
        (Session info: chrome=127.0.6533.72)
        Scenario Steps:
        96. $I->click("(//button[contains(@class, 'btn') and contains(@class, 'btn-danger') and contains(@class, 'delbutton')])[2]") at tests/acceptance/PaidEduCest.php:208
        95. $I->waitForElementClickable("(//button[contains(@class, 'btn') and contains(@class, 'btn-danger') and contains(@class, 'delbutton')])[2]") at tests/acceptance/PaidEduCest.php:207
        //$I->scrollTo('button.btn-success[value="1"]');
        //$I->scrollTo('button.btn-success[value="2"]');
        //replace type (set selector)





        /*
        $I->scrollToElementIfNotVisibleXpath($elementButtonDel1);
        $I->click(['xpath' => $elementButtonDel1]);
        $I->acceptPopup();
        $I->scrollToElementIfNotVisibleXpath($elementButtonDel2);
        $I->click(['xpath' => $elementButtonDel2]);
        $I->acceptPopup();
        $I->scrollToElementIfNotVisibleXpath($elementButtonDel3);
        $I->click(['xpath' => $elementButtonDel3]);
        $I->acceptPopup();
        $I->scrollToElementIfNotVisibleXpath($elementButtonDel4);
        $I->click(['xpath' => $elementButtonDel4]);
        $I->acceptPopup();
        */
        //$I->scrollTo('button.btn.btn-danger.delbutton:nth-child(2)');
        //$I->click('button.btn.btn-danger.delbutton:nth-child(2)');
        /*
        $buttons = $I->grabMultiple('button#delrow');
        $I->scrollTo($buttons[0]);
        $I->click("(//button[contains(@class, 'btn') and contains(@class, 'btn-danger') and contains(@class, 'delbutton')])[2]");
        //$I->click($buttons[0]);
        */
        //$buttons = $I->grabMultiple('button#add_row');
        //$I->click(['css' => 'button#add_row:nth-of-type(1)']);
        /*
        $I->scrollTo('button.btn-success[value="1"]');//$I->scrollToElementIfNotVisibleXpath($elementButtonAdd1);
        $I->click('button.[id = "add_row"][value="1"]');//$I->click(['xpath' => $elementButtonAdd1]);
        $I->scrollTo('button.btn-success[value="2"]');//$I->scrollToElementIfNotVisibleXpath($elementButtonAdd2);
        $I->click('button.btn-success[value="2"]');//$I->click($buttons[1]);//$I->click(['xpath' => $elementButtonAdd2]);
        $I->scrollTo('button.btn-success[value="3"]');//$I->scrollToElementIfNotVisibleXpath($elementButtonAdd3);
        $I->click('button.btn-success[value="3"]');//$I->click($buttons[2]);//$I->click(['xpath' => $elementButtonAdd3]);
        $I->scrollTo('button.btn-success[value="4"]');//$I->scrollToElementIfNotVisibleXpath($elementButtonAdd4);
        $I->click('button.btn-success[value="4"]');//$I->click($buttons[3]);$I->click(['xpath' => $elementButtonAdd4]);
        $I->wait(1);
        */


        //$I->see($textCommentDoc);
        //$I->see($textUploadDoc);
        // INFO: example for one of form doc
        /*
        $I->fillField(['xpath' => $xpathTextSampleContract], $textSampleContract1);
        $I->attachFile(['xpath' => '//*[@id="File0"]'], 'test_copy_1.png');
        $I->scrollToElementIfNotVisible($elementButtonSave);
        $I->click($elementButtonSave);

        $I->click(['xpath' => '/html/body/main/div/form/div[1]/div[2]/button']);
        $I->acceptPopup();

        $I->wait(1);
        */

        //$I->scrollToElementIfNotVisible($elementButtonSave);
        //$I->click($elementButtonSave);


        //$I->dontSeeElement(['xpath'=>$xpathTextSampleContract]);
        //$I->dontSeeElement(['xpath'=>$xpathTextApprovalDocument]);
        //$I->dontSeeElement(['xpath'=>$xpathTextDeliveryProcedure]);
        //$I->dontSeeElement(['xpath'=>$xpathTextEstablishmentDocument]);
 
        //$xpathTestNameForUrl1 = '//*[@id="main"]/div/form/div[1]/div[1]/input[1]';
        //$xpathTestUrl1 = '//*[@id="main"]/div/form/div[1]/div[1]/input[2]';
        //$xpathTestNameForUrl2 = '//*[@id="main"]/div/form/div[3]/div[1]/input[1]';
        //$xpathTestUrl2 = '//*[@id="main"]/div/form/div[3]/div[1]/input[2]';
        //$testUrl1 = 'https://github.com/php-webdriver/php-webdriver?tab=readme-ov-file';
        //$testUrl2 = 'https://chat.deepseek.com/coder';
        //$testUrl3 = 'https://www.deepl.com/ru/translator';
        
        /*
        данные на странице отсутствуют
        $I->isElementNotVisible('#main > div > form > div:nth-child(3) > div.col-sm-11 > label:nth-child(1)');
        $I->isElementNotVisible('#main > div > form > div:nth-child(3) > div.col-sm-11 > label:nth-child(4)');
        $I->dontSee($textCommentDoc);
        $I->dontSee($textUploadDoc)
        */

        /*
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
        */

        //мы на странице и видим данные 1
        //$I->isElementVisible('#main > div > form > div:nth-child(3) > div.col-sm-11 > label:nth-child(1)');
        //$I->isElementVisible('#main > div > form > div:nth-child(3) > div.col-sm-11 > label:nth-child(4)');

        /*
        $I->seeInField($xpathTestNameForUrl1,$testNameForUrl1);
        $I->seeInField($xpathTestUrl1,$testUrl1);
        //2 и 3 часть не внесена
        $I->dontSeeElement(['xpath'=>$xpathTestNameForUrl2]);
        $I->dontSeeElement(['xpath'=>$xpathTestUrl2]);
        */
        /*
        //вызов формы
        $buttons = $I->grabMultiple('button#add_row');
        $I->click(['xpath' => '/html/body/main/div/form/div[3]/button']);
        //внесли данные 2
        //$I->fillField(['xpath' => $xpathTestNameForUrl2], $testNameForUrl2);
        //$I->fillField(['xpath' => $xpathTestUrl2], $testUrl2);
        $I->scrollToElementIfNotVisible($elementButtonSave);
        $I->click($elementButtonSave);
        */


        /*
        $I->seeInField($xpathTestNameForUrl1,$testNameForUrl1);
        $I->seeInField($xpathTestUrl1,$testUrl1);
        $I->seeInField($xpathTestNameForUrl2,$testNameForUrl2);
        $I->seeInField($xpathTestUrl2,$testUrl2);
        */

        //3 часть не внесена в поля 2
        #Assert::assertEquals('expected', 'actual');
        /*
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
        //$I->see($textCommentDoc);
        //$I->see($textUploadDoc);

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
    }
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
    
}