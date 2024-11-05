<?php

//use AcceptanceTester;

use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Dataforms;


use yii\helpers\Url;
//use Codeception\Util\Assert;

use \Codeception\Util\Shared\Asserts;



class CateringCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/specialsection/section/catering';

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

    public function testCateringAction(AcceptanceTester $I)
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

        $xpathButtonAdd0 = '/html/body/main/div/form/div[1]/button';
        $xpathButtonAdd1 = '/html/body/main/div/form/div[3]/button';

        $xpathButtonSave = '/html/body/main/div/form/div[5]/button';

        $I->scrollToElementIfNotVisibleXpath($xpathButtonAdd0);
        $I->click($xpathButtonAdd0);
        $I->scrollToElementIfNotVisibleXpath($xpathButtonAdd1);
        $I->click($xpathButtonAdd1);

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

        $I->scrollToElementIfNotVisibleXpath($xpathButtonSave);
        $I->click($xpathButtonSave);
    }

}