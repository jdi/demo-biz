<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use Fortifi\FortifiApi\Affiliate\Enums\AffiliateBuiltInAction;
use Fortifi\FortifiApi\Affiliate\Enums\ReversalReason;
use Packaged\Helpers\Arrays;
use Packaged\Helpers\Strings;

class RefundController extends BaseController
{
  public function postDefaultAction()
  {
    $reqData = $this->_getRequest()->request->all();
    $eventRef = Arrays::value($reqData, 'event_ref');

    switch(Arrays::value($reqData, 'type'))
    {
      case 'join':
        $type = AffiliateBuiltInAction::LEAD;
        break;
      case 'sale':
      default:
        $type = AffiliateBuiltInAction::ACQUISITION;
        break;
    }

    //Trigger Fortifi Join
    $this->_getFortifi()->visitor()->reverseAction(
      $eventRef,
      $type,
      ReversalReason::CANCEL,
      Strings::randomString(6),
      Arrays::value($reqData, 'amount'),
      $reqData
    );

    echo '<div class="row"><div class="box"><div class="col-lg-12">';

    //echo '<h3>' . ($resp ? 'Refund successful' : 'Refund failed') . '</h3>';

    echo '</div></div></div>';
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Refund');
  }
}
