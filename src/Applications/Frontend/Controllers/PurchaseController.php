<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use Fortifi\FortifiApi\Affiliate\Enums\AffiliateBuiltInAction;
use Packaged\Dispatch\AssetManager;
use Packaged\Helpers\Arrays;
use Packaged\Helpers\Strings;

class PurchaseController extends BaseController
{
  public function postDefaultAction()
  {
    $reqData = $this->_getRequest()->request->all();
    $eventRef = Arrays::value($reqData, 'event_ref', Strings::randomString(6));

    //Trigger Fortifi Join
    $this->_getFortifi()->visitor()->triggerAction(
      'FID:COMP:1429731764:3d9f2a4ed06c',
      AffiliateBuiltInAction::ACQUISITION,
      $eventRef,
      Arrays::value($reqData, 'amount'),
      $reqData,
      $reqData['coupon'],
      false
    );

    // pixels are triggered by JS for purchase
    // CSS to make the pixel box visible
    AssetManager::assetType()->requireInlineCss(
      '#fortifi-px-container { width:initial!important;height:initial!important;position:initial!important;top:initial!important;left:initial!important; }'
    );
    AssetManager::assetType()->requireInlineJs('(function (d, s, i, u)
  {
    if (d.getElementById(i))
    {return;}
    var n = d.createElement(s), e = d.getElementsByTagName(s)[0];
    n.id = i;
    n.src = \'//\' + u + \'/px/init/fortifi.js\';
    e.parentNode.insertBefore(n, e);
  })(
    document, "script", "fortifi-pixel",
    "'. $this->getConfigItem('fortifi','track') .'"
  );
');
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Purchase');
  }
}
