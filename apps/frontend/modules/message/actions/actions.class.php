<?php

/**
 * message actions.
 *
 * @package    trad
 * @subpackage message
 * @author     eMerzh
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class messageActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->messages = Doctrine::getTable('Message')->getMessagesForTranslation(
      $request->getParameter('part'),
      $request->getParameter('lang')
    );
  }
}
