<?php

//use AcceptanceTester;

use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Dataforms;


use yii\helpers\Url;
//use Codeception\Util\Assert;

use \Codeception\Util\Shared\Asserts;



class InterCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/specialsection/section/inter';

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

    public function testTextOnPage(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
    }

    public function submitValidData(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
        $NameGoverment0 = 'test0';
        $NameGoverment1 = 'test1';

        $NameOrganisation0 = 'test3';
        $NameOrganisation1 = 'test4';

        $ContractDetails00 = 'test5';
        $ContractDetails01 = 'test6';
        $ContractDetails10 = 'test7';
        $ContractDetails11 = 'test8';

        $xpathButtonGlobalAdd0 = '/html/body/main/div/form/div[1]/button';
        $xpathButtonGlobalAdd1 = '/html/body/main/div/form/div[2]/button';

        $xpathButtonLocalAdd00 = '/html/body/main/div/form/div[1]/div[3]/div/button';
        $xpathButtonLocalAdd01 ='/html/body/main/div/form/div[1]/div[3]/div[2]/button';

        $xpathButtonLocalAdd10 = '/html/body/main/div/form/div[2]/div[3]/div/button';
        $xpathButtonLocalAdd11 = '/html/body/main/div/form/div[2]/div[3]/div[2]/button';

        $xpathInputNameGov0 = '/html/body/main/div/form/div[1]/div[1]/input';
        $xpathInputNameGov1 ='/html/body/main/div/form/div[2]/div[1]/input';

        $xpathInputNameOrg0 = '/html/body/main/div/form/div[1]/div[2]/input';
        $xpathInputNameOrg1 = '/html/body/main/div/form/div[2]/div[2]/input';

        $xpathInputConDet00 = '/html/body/main/div/form/div[1]/div[3]/div[1]/div[1]/input';
        $xpathInputConDet01 = '/html/body/main/div/form/div[1]/div[3]/div[2]/div[1]/input';

        $xpathInputConDet10 = '/html/body/main/div/form/div[2]/div[3]/div[1]/div[1]/input';
        $xpathInputConDet11 = '/html/body/main/div/form/div[2]/div[3]/div[2]/div[1]/input';

        $xpathButtonSave = '/html/body/main/div/form/div[4]/button';

        $I->scrollToElementIfNotVisibleXpath($xpathButtonGlobalAdd0);
        $I->click($xpathButtonGlobalAdd0);

        $I->scrollToElementIfNotVisibleXpath($xpathButtonGlobalAdd1);
        $I->click($xpathButtonGlobalAdd1);
        
        $I->scrollToElementIfNotVisibleXpath($xpathButtonLocalAdd00);
        $I->click($xpathButtonLocalAdd00);

        $I->scrollToElementIfNotVisibleXpath($xpathButtonLocalAdd01);
        $I->click($xpathButtonLocalAdd01);

        $I->scrollToElementIfNotVisibleXpath($xpathButtonLocalAdd10);
        $I->click($xpathButtonLocalAdd10);

        $I->scrollToElementIfNotVisibleXpath($xpathButtonLocalAdd11);
        $I->click($xpathButtonLocalAdd11);

        $I->scrollToElementIfNotVisibleXpath($xpathInputNameGov0);
        $I->fillField(['xpath' => $xpathInputNameGov0], $NameGoverment0);

        $I->scrollToElementIfNotVisibleXpath($xpathInputNameGov1);
        $I->fillField(['xpath' => $xpathInputNameGov1], $NameGoverment1);

        $I->scrollToElementIfNotVisibleXpath($xpathInputNameOrg0);
        $I->fillField(['xpath' => $xpathInputNameOrg0], $NameOrganisation0);
        
        $I->scrollToElementIfNotVisibleXpath($xpathInputNameOrg1);
        $I->fillField(['xpath' => $xpathInputNameOrg1], $NameOrganisation1);

        $I->scrollToElementIfNotVisibleXpath($xpathInputConDet00);
        $I->fillField(['xpath' => $xpathInputConDet00], $ContractDetails00);

        $I->scrollToElementIfNotVisibleXpath($xpathInputConDet01);
        $I->fillField(['xpath' => $xpathInputConDet01], $ContractDetails01);

        $I->scrollToElementIfNotVisibleXpath($xpathInputConDet10);
        $I->fillField(['xpath' => $xpathInputConDet10], $ContractDetails10);

        $I->scrollToElementIfNotVisibleXpath($xpathInputConDet11);
        $I->fillField(['xpath' => $xpathInputConDet11], $ContractDetails11);

        $I->scrollToElementIfNotVisibleXpath($xpathButtonSave);
        $I->click($xpathButtonSave);
    }
}