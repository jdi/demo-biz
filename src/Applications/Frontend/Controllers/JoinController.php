<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use Cubex\View\LayoutController;
use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;

class JoinController extends LayoutController
{
  public function postDefaultAction()
  {
    //Trigger Join
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Join');
  }
}
