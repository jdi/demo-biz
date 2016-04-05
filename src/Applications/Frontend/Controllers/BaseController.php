<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use Cubex\View\LayoutController;
use Fortifi\Api\Core\ApiDefinition\ApiDefinition;
use Fortifi\Api\Core\Connections\RequestsConnection;
use Fortifi\Api\Core\OAuth\Grants\ServiceAccountGrant;
use Fortifi\Api\V1\APIs\StageFortifiApi;
use Fortifi\Api\V1\Endpoints\FortifiApi;

class BaseController extends LayoutController
{
  private $_fortifi;
  protected $_companyFid;

  /**
   * @return FortifiApi
   */
  protected function _getFortifi()
  {
    if($this->_fortifi === null)
    {
      $cfg = $this->getCubex()->getConfiguration()->getSection('fortifi');

      $connection = new RequestsConnection();
      $connection->setOrganisationFid($cfg->getItem('org'));

      $endpoint = new StageFortifiApi();
      $def = $endpoint->getApiDefinition();
      if($def instanceof ApiDefinition)
      {
        $def->setHost('api.fortel.li:9090');
        $def->setSchemas(['http']);
      }
      $endpoint->setConnection($connection);

      $endpoint->setAccessGrant(
        new ServiceAccountGrant(
          $cfg->getItem('api_user'), $cfg->getItem('api_secret')
        )
      );

      $this->_fortifi = $endpoint;
    }
    return $this->_fortifi;
  }

  protected function _init()
  {
    $cfg = $this->getCubex()->getConfiguration()->getSection('fortifi');
    $this->_companyFid = $cfg->getItem('company_fid');

    $this->layout()->setData(
      'fortifi.track.domain',
      $this->getConfigItem('fortifi', 'track')
    );
    $this->layout()->setData(
      'fortifi.chat.domain',
      $this->getConfigItem('fortifi', 'chat')
    );
    $this->layout()->setData(
      'fortifi.chat.protocol',
      $this->getConfigItem('fortifi', 'protocol')
    );
  }
}
