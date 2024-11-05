<?php

//use AcceptanceTester;

use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Dataforms;


use yii\helpers\Url;
//use Codeception\Util\Assert;

use \Codeception\Util\Shared\Asserts;



class ObjectsCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/specialsection/section/objects';

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

    public function testObjectsAction(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
    }


    public function submitValidData(AcceptanceTester $I)
    {

        $I->maximizeWindow();

        $textNameObject0 = 'object1';
        $textNameObject1 = 'object2';

        $textAddressObject0 = 'address1';
        $textAddressObject1 = 'address2';

        $textAreaObject0 = '1';
        $textAreaObject1 = '2';

        $textNumberSeats0 = '3';
        $textNumberSeats1 = '4';

        $textAdaptability0 = '0';
        $textAdaptability1 = '1';

        $textField0 = 'text1';
        $textField1 = 'text2';
        $textField2 = 'text3';
        $textField3 = 'text4';
        $textField4 = 'text5';
        $textField5 = 'text6';
        $textField6 = '00000';
        $textField7 = '11111';
        $textField8 = '22222';
        $textField9 = 'text8';
        $textField10 = 'text9';

        $textNameUrl0 = 'deepl';
        $textNameUrl1 = 'minio';

        $textContextUrl0 = 'https://www.deepl.com/ru/translator';
        $textContextUrl1 = 'https://127.0.0.1:9001/browser/testbucket';

        $xpathNameObject0 = '/html/body/main/div/form/div[1]/div[1]/input[2]';
        $xpathNameObject1 = '/html/body/main/div/form/div[3]/div[1]/input[2]';

        $xpathAddressObject0 = '/html/body/main/div/form/div[1]/div[2]/input[2]';
        $xpathAddressObject1 = '/html/body/main/div/form/div[3]/div[2]/input[2]';

        $xpathAreaObject0 = '/html/body/main/div/form/div[1]/div[3]/input[2]';
        $xpathAreaObject1 = '/html/body/main/div/form/div[3]/div[3]/input[2]';

        $xpathNumberSeats0 = '/html/body/main/div/form/div[1]/div[4]/input[2]';
        $xpathNumberSeats1 = '/html/body/main/div/form/div[3]/div[4]/input[2]';

        $xpathAdaptability0 = '/html/body/main/div/form/div[1]/div[5]/input[2]';
        $xpathAdaptability1 = '/html/body/main/div/form/div[3]/div[5]/input[2]';

        $xpathField0 = '/html/body/main/div/form/input[8]';
        $xpathField1 = '/html/body/main/div/form/input[12]';
        $xpathField2 = '/html/body/main/div/form/input[16]';
        $xpathField3 = '/html/body/main/div/form/input[20]';
        $xpathField4 = '/html/body/main/div/form/input[24]';
        $xpathField5 = '/html/body/main/div/form/input[28]';
        $xpathField6 = '/html/body/main/div/form/input[32]';
        $xpathField7 = '/html/body/main/div/form/input[36]';
        $xpathField8 = '/html/body/main/div/form/input[40]';
        $xpathField9 = '/html/body/main/div/form/input[44]';
        $xpathField10 = '/html/body/main/div/form/input[48]';

        $xpathNameUrl0 = '/html/body/main/div/form/div[5]/div[1]/input[1]';
        $xpathNameUrl1 = '/html/body/main/div/form/div[7]/div[1]/input[1]';

        $xpathContextUrl0 = '/html/body/main/div/form/div[5]/div[1]/input[2]';
        $xpathContextUrl1 = '/html/body/main/div/form/div[7]/div[1]/input[2]';

        $xpathButtonAdd0 = '/html/body/main/div/form/div[1]/button';
        $xpathButtonAdd1 = '/html/body/main/div/form/div[3]/button';
        $xpathButtonAdd2 = '/html/body/main/div/form/div[5]/button';
        $xpathButtonAdd3 = '/html/body/main/div/form/div[7]/button';

        $xpathButtonSave = '/html/body/main/div/form/div[9]/button';

        $I->scrollToElementIfNotVisibleXpath($xpathButtonAdd0);
        $I->click($xpathButtonAdd0);
        $I->scrollToElementIfNotVisibleXpath($xpathButtonAdd1);
        $I->click($xpathButtonAdd1);
        $I->scrollToElementIfNotVisibleXpath($xpathButtonAdd2);
        $I->click($xpathButtonAdd2);
        $I->scrollToElementIfNotVisibleXpath($xpathButtonAdd3);
        $I->click($xpathButtonAdd3);

        $I->scrollToElementIfNotVisibleXpath($xpathNameObject0);
        $I->fillField(['xpath' => $xpathNameObject0], $textNameObject0);
        $I->scrollToElementIfNotVisibleXpath($xpathNameObject1);
        $I->fillField(['xpath' => $xpathNameObject1], $textNameObject1);

        $I->scrollToElementIfNotVisibleXpath($xpathAddressObject0);
        $I->fillField(['xpath' => $xpathAddressObject0], $textAddressObject0);
        $I->scrollToElementIfNotVisibleXpath($xpathAddressObject1);
        $I->fillField(['xpath' => $xpathAddressObject1], $textAddressObject1);

        $I->scrollToElementIfNotVisibleXpath($xpathAreaObject0);
        $I->fillField(['xpath' => $xpathAreaObject0], $textAreaObject0);
        $I->scrollToElementIfNotVisibleXpath($xpathAreaObject1);
        $I->fillField(['xpath' => $xpathAreaObject1], $textAreaObject1);

        $I->scrollToElementIfNotVisibleXpath($xpathNumberSeats0);
        $I->fillField(['xpath' => $xpathNumberSeats0], $textNumberSeats0);
        $I->scrollToElementIfNotVisibleXpath($xpathNumberSeats1);
        $I->fillField(['xpath' => $xpathNumberSeats1], $textNumberSeats1);

        $I->scrollToElementIfNotVisibleXpath($xpathAdaptability0);
        $I->fillField(['xpath' => $xpathAdaptability0], $textAdaptability0);
        $I->scrollToElementIfNotVisibleXpath($xpathAdaptability1);
        $I->fillField(['xpath' => $xpathAdaptability1], $textAdaptability1);

        $I->scrollToElementIfNotVisibleXpath($xpathField0);
        $I->fillField(['xpath' => $xpathField0], $textField0);

        $I->scrollToElementIfNotVisibleXpath($xpathField1);
        $I->fillField(['xpath' => $xpathField1], $textField1);

        $I->scrollToElementIfNotVisibleXpath($xpathField2);
        $I->fillField(['xpath' => $xpathField2], $textField2);

        $I->scrollToElementIfNotVisibleXpath($xpathField3);
        $I->fillField(['xpath' => $xpathField3], $textField3);        

        $I->scrollToElementIfNotVisibleXpath($xpathField4);
        $I->fillField(['xpath' => $xpathField4], $textField4);

        $I->scrollToElementIfNotVisibleXpath($xpathField5);
        $I->fillField(['xpath' => $xpathField5], $textField5);

        $I->scrollToElementIfNotVisibleXpath($xpathField6);
        $I->fillField(['xpath' => $xpathField6], $textField6);

        $I->scrollToElementIfNotVisibleXpath($xpathField7);
        $I->fillField(['xpath' => $xpathField7], $textField7);

        $I->scrollToElementIfNotVisibleXpath($xpathField8);
        $I->fillField(['xpath' => $xpathField8], $textField8);

        $I->scrollToElementIfNotVisibleXpath($xpathField9);
        $I->fillField(['xpath' => $xpathField9], $textField9);

        $I->scrollToElementIfNotVisibleXpath($xpathField10);
        $I->fillField(['xpath' => $xpathField10], $textField10);

        $I->scrollToElementIfNotVisibleXpath($xpathNameUrl0);
        $I->fillField(['xpath' => $xpathNameUrl0], $textNameUrl0);

        $I->scrollToElementIfNotVisibleXpath($xpathNameUrl1);
        $I->fillField(['xpath' => $xpathNameUrl1], $textNameUrl1);

        $I->scrollToElementIfNotVisibleXpath($xpathContextUrl0);
        $I->fillField(['xpath' => $xpathContextUrl0], $textContextUrl0);

        $I->scrollToElementIfNotVisibleXpath($xpathContextUrl1);
        $I->fillField(['xpath' => $xpathContextUrl1], $textContextUrl1);

        $I->scrollToElementIfNotVisibleXpath($xpathButtonSave);
        $I->click($xpathButtonSave);
    }

}