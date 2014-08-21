<?php
namespace DemoCorp\Applications\Frontend\Views;

use Cubex\View\TemplatedView;
use Packaged\Dispatch\AssetManager;

class AssetTemplatedView extends TemplatedView
{
  protected $_assetManager;

  public function assetManager()
  {
    if($this->_assetManager === null)
    {
      $this->_assetManager = AssetManager::assetType();
    }
    return $this->_assetManager;
  }
}
