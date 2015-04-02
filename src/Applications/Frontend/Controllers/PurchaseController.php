<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use Packaged\Helpers\Strings;

class PurchaseController extends BaseController
{
  public function postDefaultAction()
  {
    $reqData = $this->_getRequest()->request->all();
    $eventRef = idx($reqData, 'event_ref', Strings::randomString(6));

    //Trigger Fortifi Join
    $this->_getFortifi()->customer()->purchase(
      'FID:COMP:1427969151:fa2875781cd3',
      $eventRef,
      idx($reqData, 'amount'),
      $reqData
    );

    echo '<div class="row"><div class="box"><div class="col-lg-12">';

    echo '<h4>Fortifi Pixels</h4>';
    foreach($this->_getFortifi()->visitor()->getPixels() as $pixel)
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
