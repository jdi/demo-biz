<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use Cubex\View\LayoutController;
use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use JDI\TntAffiliate\Models\ActionOptions;
use JDI\TntAffiliate\TntAffiliate;
use JDI\TntAffiliate\TntAffiliateApi;

class PurchaseController extends LayoutController
{
  public function postDefaultAction()
  {
    //Trigger Purchase
    $api    = new TntAffiliateApi();
    $config = $this->getCubex()->getConfiguration()->getSection('tntaffiliate');
    $api->login(
      $config->getItem('client_id'),
      $config->getItem('client_secret')
    );
    $options       = new ActionOptions();
    $options->data = $this->_getRequest()->request->all();
    $resp          = $api->triggerAction(
      'sale',
      TntAffiliate::getVisitorId(),
      $options
    );
    return [
      'action_id' => $resp->getActionId(),
      'pixels'    => $resp->getPixels()
    ];
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Purchase');
  }
}
