<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use Cubex\View\LayoutController;
use Fortifi\Sdk\Fortifi;

class BaseController extends LayoutController
{
  private $_fortifi;

  protected function _getFortifi()
  {
    if($this->_fortifi === null)
    {
      $cfg = $this->getCubex()->getConfiguration()->getSection('fortifi');

      Fortifi::$apiHost = 'sapi.fortifi.co'; //This line is for sandbox accounts only

      $this->_fortifi = Fortifi::getInstance(
        $cfg->getItem('org'),
        $cfg->getItem('api_user'),
        $cfg->getItem('api_secret')
      );
    }
    return $this->_fortifi;
  }

  protected function _init()
  {
    $this->layout()->setData(
      'tnt.pixel',
      $this->getConfigItem('tntaffiliate', 'pixel')
    );
    $this->layout()->setData(
      'fortifi.pixel',
      $this->getConfigItem('fortifi', 'pixel')
    );
    $this->layout()->setData(
      'tnt.login',
      $this->getConfigItem('tntaffiliate', 'login')
    );
  }
}
