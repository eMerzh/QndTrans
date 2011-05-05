<?php

/**
 * part actions.
 *
 * @package    trad
 * @subpackage part
 * @author     eMerzh
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->parts = Doctrine::getTable('Part')->getPartsWithMessages();
  }

  public function executeChooselang(sfWebRequest $request)
  {
    $this->langs = Doctrine::getTable('Language')->getLangsForPart($request->getParameter('part'));
    $this->message_number = Doctrine::getTable('Message')->getCountForPart($request->getParameter('part'));
  }
}
