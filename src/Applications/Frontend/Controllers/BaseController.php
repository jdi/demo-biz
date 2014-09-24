<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use Cubex\View\LayoutController;

class BaseController extends LayoutController
{
  public function init()
  {
    $this->layout()->setData(
      'tnt.pixel',
      $this->getConfigItem('tntaffiliate', 'pixel')
    );
    $this->layout()->setData(
      'tnt.login',
      $this->getConfigItem('tntaffiliate', 'login')
    );
  }
}
