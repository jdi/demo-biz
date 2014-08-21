<?php
namespace DemoCorp;

use Cubex\Kernel\CubexKernel;
use DemoCorp\Applications\Frontend\FrontendApplication;

class Project extends CubexKernel
{
  public function defaultAction()
  {
    return new FrontendApplication();
  }
}
