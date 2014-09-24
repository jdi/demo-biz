<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;

class DefaultController extends BaseController
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
