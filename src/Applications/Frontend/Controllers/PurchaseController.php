<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use Fortifi\FortifiApi\Affiliate\Enums\AffiliateBuiltInAction;
use Fortifi\Sdk\Models\Visitor;
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
      $reqData
    );

    echo '<div class="row"><div class="box"><div class="col-lg-12">';

    echo '<h4>Fortifi Pixels</h4>';
    foreach($this->_getFortifi()->visitor()->getPixels() as $pixel)
    {
      echo '<textarea cols="100" rows="6">'
        . Strings::escape($pixel)
        . '</textarea><br/>';
    }

    echo '</div></div></div>';
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Purchase');
  }
}
