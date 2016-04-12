<?php
namespace DemoCorp\Applications;

use Fortifi\Api\Core\ApiDefinition\ApiDefinition;
use Fortifi\Api\V1\Endpoints\FortifiApi;

class LocalFortifiApi extends FortifiApi
{
  public function __construct()
  {
    parent::__construct();
    $def = $this->getApiDefinition();
    if($def instanceof ApiDefinition)
    {
      $def->setHost('api.fortifi.me:9090');
      $def->setSchemas(['http']);
    }
  }
}
