<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use JDI\TntAffiliate\Models\ActionOptions;
use JDI\TntAffiliate\TntAffiliate;
use JDI\TntAffiliate\TntAffiliateApi;
use Packaged\Helpers\Strings;

class JoinController extends BaseController
{
  public function postDefaultAction()
  {
    $reqData = $this->_getRequest()->request->all();
    $eventRef = idx($reqData, 'event_ref', Strings::randomString(10));

    //Trigger Fortifi Join
    $this->_getFortifi()->customer()->create(
      'FID:COMP:1427969151:fa2875781cd3',
      idx($reqData, 'email'),
      idx($reqData, 'first_name'),
      null,
      null,
      $eventRef
    );

    //Trigger Join
    $config = $this->getCubex()->getConfiguration()->getSection('tntaffiliate');
    $api = new TntAffiliateApi($config->getItem('endpoint'));
    $api->login(
      $config->getItem('client_id'),
      $config->getItem('client_secret')
    );
    $options = new ActionOptions();
    $options->pixels = true;
    $options->data = $reqData;
    $options->eventReference = $eventRef;
    $resp = $api->triggerAction(
      'lead',
      TntAffiliate::getVisitorId(),
      $options
    );

    echo '<div class="row"><div class="box"><div class="col-lg-12">';

    echo '<h3>' . $resp->getActionId() . '</h3>';

    echo '<h4>Fortifi Pixels</h4>';
    foreach($this->_getFortifi()->visitor()->getPixels() as $pixel)
    {
      echo '<textarea cols="100" rows="6">' . esc($pixel) . '</textarea><br/>';
    }

    echo '<h4>TNT Pixels</h4>';
    foreach($resp->getPixels() as $pixel)
    {
      echo '<textarea cols="100" rows="6">' . esc($pixel) . '</textarea><br/>';
    }

    echo '</div></div></div>';
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Join');
  }
}
