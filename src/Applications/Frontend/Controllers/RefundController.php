<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use JDI\TntAffiliate\Models\RefundOptions;
use JDI\TntAffiliate\TntAffiliateApi;

class RefundController extends BaseController
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
    $options         = new RefundOptions();
    $options->reason = $this->_getRequest()->request->get('reason');
    $options->type   = $this->_getRequest()->request->get('type');
    $resp            = $api->refund(
      $this->_getRequest()->request->get('event_ref'),
      $options
    );

    echo '<div class="row"><div class="box"><div class="col-lg-12">';

    echo '<h3>' . ($resp ? 'Refund successful' : 'Refund failed') . '</h3>';

    echo '</div></div></div>';
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Refund');
  }
}
