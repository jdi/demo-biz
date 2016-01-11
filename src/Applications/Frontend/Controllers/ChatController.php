<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;

class ChatController extends BaseController
{
  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Chat');
  }
}
