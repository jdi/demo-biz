<?php
namespace DemoCorp\Applications\Frontend;

use Cubex\Kernel\ApplicationKernel;
use DemoCorp\Applications\Frontend\Controllers\DefaultController;

class FrontendApplication extends ApplicationKernel
{
  public function defaultAction()
  {
    return new DefaultController();
  }
}
