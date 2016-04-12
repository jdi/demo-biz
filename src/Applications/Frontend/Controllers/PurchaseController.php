<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use Fortifi\Api\V1\Helpers\VisitorHelper;
use Fortifi\Api\V1\Payloads\PostActionPayload;
use Packaged\Dispatch\AssetManager;
use Packaged\Helpers\Strings;

class PurchaseController extends BaseController
{
  public function postDefaultAction()
  {
    $reqData = $this->_getRequest()->request;
    $eventRef = $reqData->get('event_ref', Strings::randomString(6));

    //Trigger Fortifi Purchase
    $purchaseCreate = new PostActionPayload();
    $purchaseCreate->setTime(gmdate(\DateTime::ISO8601));
    $purchaseCreate->setCouponCode($reqData->get('coupon'));
    $purchaseCreate->setTransactionId($eventRef);
    $purchaseCreate->setTransactionValue($reqData->get('amount'));
    $purchaseCreate->setMetaData($reqData->all());
    $purchaseCreate->setCompanyFid($this->_companyFid);
    $purchaseCreate->setClientIp(VisitorHelper::getClientIp());
    $purchaseCreate->setReturnPixels(false);
    $fortifiRequest = $this->_getFortifi()->visitors()
      ->with(VisitorHelper::getCookieVisitorId())
      ->actions()->with('acquisition')
      ->create($purchaseCreate);

    try
    {
      var_dump($fortifiRequest->wasSuccessful());
      var_dump($fortifiRequest->getRawResult());
    }
    catch(\Exception $e)
    {
      var_dump($e);
    }

    // pixels are triggered by JS for purchase and inserted into #fortifi-px-container
    $trackDomain = $this->getConfigItem('fortifi', 'track');
    AssetManager::assetType()->requireInlineJs(
      <<<FIN
(function (d, s, i, u)
{
  if (d.getElementById(i)) {return;}
  var n = d.createElement(s), e = d.getElementsByTagName(s)[0];
  n.id = i;
  n.src = '//' + u + '/px/init/fortifi.js';
  e.parentNode.insertBefore(n, e);
})(document, "script", "fortifi-pixel", "$trackDomain");
FIN
    );
    echo '<div class="row"><div class="box"><div class="col-lg-12">';
    echo '<h4>Pixels (JS)</h4><div id="fortifi-px-container"></div>';
    echo '</div></div></div>';
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Purchase');
  }
}
