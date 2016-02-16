<?php
namespace DemoCorp\Applications\Frontend\Controllers;

use DemoCorp\Applications\Frontend\Views\AssetTemplatedView;
use Fortifi\FortifiApi\Affiliate\Responses\Pixels\PixelsResponse;
use Packaged\Helpers\Strings;

class JoinController extends BaseController
{
  public function defaultAction()
  {
    return new AssetTemplatedView($this, 'Join');
  }

  public function postDefaultAction()
  {
    $post = $this->_getRequest()->request;

    //Trigger Fortifi Join
    $this->_getFortifi()->customer()->create(
      'FID:COMP:1454595603:9HOP5UWRfGwf',
      $post->get('email'),
      $post->get('firstname'),
      null,
      null,
      $post->get('event_ref', Strings::randomString(10))
    );

    echo '<div class="row"><div class="box"><div class="col-lg-12">';
    echo '<h4>Fortifi Pixels</h4>';

    $pixels = $this->_getFortifi()->visitor()->getPixels();
    if($pixels instanceof PixelsResponse)
    {
      foreach($pixels->items as $pixel)
      {
        echo '<textarea cols="100" rows="6">'
          . Strings::escape($pixel)
          . '</textarea><br/>';
      }
    }

    echo '</div></div></div>';
  }
}
