<?php
use PHPUnit\Framework\Assert;



/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;
    use \Codeception\Util\Shared\Asserts;

    /**
    * Define custom actions here
    */

    public function scrollToElementIfNotVisible($selector, $maxAttempts = 10)
    {
        $attempt = 0;

        while (!$this->isElementVisible($selector) && $attempt < $maxAttempts) {
            $this->scrollTo($selector);
            $attempt++;
        }
    }
    public function scrollToElementIfNotVisibleXpath($selector, $maxAttempts = 10)
    {
        $attempt = 0;

        while (!$this->isElementVisibleXpath($selector) && $attempt < $maxAttempts) {
            $this->scrollTo($selector);
            $attempt++;
        }
    }

    public function isElementVisible($selector)
    {
        return $this->executeJS("return document.querySelector('$selector').getBoundingClientRect().top < window.innerHeight;");
    }

    public function isElementVisibleXpath2($xpath)
    {
        $script = <<<JS
            var element = document.evaluate("$xpath", document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
            if (element) {
                return element.getBoundingClientRect().top < window.innerHeight;
            }
            return false;
        JS;

        return $this->executeJS($script);
    }

    public function isElementVisibleXpath($xpath)
{
    $jsCode = "
        var xpathResult = document.evaluate('$xpath', document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null);
        var element = xpathResult.singleNodeValue;
        if (element) {
            return element.getBoundingClientRect().top < window.innerHeight;
        }
        return false;
    ";
    return $this->executeJS($jsCode);
}

    public function isElementNotVisible($selector)
    {
        return $this->executeJS("return document.querySelector('$selector').getBoundingClientRect().top < window.innerHeight;");
    }

    //Asserts::assertEquals

    


}
