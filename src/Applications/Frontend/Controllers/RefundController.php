<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use Fortifi\Api\V1\Enums\ReversalReason;
use Fortifi\Api\V1\Helpers\VisitorHelper;
use Fortifi\Api\V1\Payloads\ReverseActionPayload;
use Packaged\Helpers\Strings;

class RefundController extends BaseController
{
  public function postRefund()
  {
    $reqData = $this->_getRequest()->request;
    $eventRef = $reqData->get('event_ref');

    switch($reqData->get('type'))
    {
      case 'join':
        $type = 'lead';
        break;
      case 'sale':
      default:
        $type = 'acquisition';
        break;
    }

    //Trigger Fortifi Reversal
    $reversalPayload = new ReverseActionPayload();
    $reversalPayload->setReason(ReversalReason::CANCEL);
    $reversalPayload->setSourceTransactionId($eventRef);
    $reversalPayload->setReversalId(Strings::randomString(6));
    $reversalPayload->setReversalAmount($reqData->get('amount'));
    $reversalPayload->setMetaData($reqData->all());
    $fortifiRequest = $this->_getFortifi()->visitors()
      ->with(VisitorHelper::getCookieVisitorId())->actions()->with($type)
      ->createReverse($reversalPayload);

    echo '<div class="row"><div class="box"><div class="col-lg-12">';
    try
    {
      var_dump($fortifiRequest->wasSuccessful());
      var_dump($fortifiRequest->getRawResult());
    }
    catch(\Exception $e)
    {
      var_dump($e);
    }

    echo '</div></div></div>';
  }

  public function getRefund()
  {
    return new AssetTemplatedView($this, 'Refund');
  }
}
