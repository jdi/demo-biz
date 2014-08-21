<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use Cubex\View\LayoutController;
use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;

class DefaultController extends LayoutController
{
  public function about()
  {
    return new AssetTemplatedView($this, 'About');
  }

  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Homepage');
  }
}
