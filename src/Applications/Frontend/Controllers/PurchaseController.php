<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use Cubex\View\LayoutController;
use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;

class PurchaseController extends LayoutController
{
  public function postDefaultAction()
  {
    //Trigger Purchase
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Purchase');
  }
}
