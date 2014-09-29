<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use JDI\TntAffiliate\Models\ActionOptions;
use JDI\TntAffiliate\TntAffiliate;
use JDI\TntAffiliate\TntAffiliateApi;
use Packaged\Helpers\Strings;

class PurchaseController extends BaseController
{
  public function postDefaultAction()
  {
    //Trigger Purchase
    $config = $this->getCubex()->getConfiguration()->getSection('tntaffiliate');
    $api    = new TntAffiliateApi($config->getItem('endpoint'));
    $api->login(
      $config->getItem('client_id'),
      $config->getItem('client_secret')
    );
    $options                 = new ActionOptions();
    $options->pixels         = true;
    $options->data           = $this->_getRequest()->request->all();
    $options->eventReference = $this->_getRequest()->request->get('event_ref');
    $options->coupon         = $this->_getRequest()->request->get('coupon');
    if(empty($options->eventReference))
    {
      $options->eventReference = Strings::randomString(6);
    }
    $resp = $api->triggerAction(
      'sale',
      TntAffiliate::getVisitorId(),
      $options
    );

    echo '<div class="row"><div class="box"><div class="col-lg-12">';

    echo '<h3>' . $resp->getActionId() . '</h3>';

    foreach($resp->getPixels() as $pixel)
    {
      echo '<textarea cols="100" rows="6">' . esc($pixel) . '</textarea><br/>';
    }

    echo '</div></div></div>';
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Purchase');
  }
}
