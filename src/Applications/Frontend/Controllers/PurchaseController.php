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
