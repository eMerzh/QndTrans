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
    $this->part_id = $request->getParameter('part');
    $this->langs = Doctrine::getTable('Language')->getLangsForPart($request->getParameter('part'));
    $this->message_number = Doctrine::getTable('Message')->getCountForPart($request->getParameter('part'));
  }

  public function executeAddMessage(sfWebRequest $request)
  {
    $this->part = Doctrine::getTable('Part')->find($request->getParameter('part'));
    $mess = new Message();
    $mess->setPartId($this->part->getId());
    $this->form = new MessageForm($mess);
    
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('message'));
      if ($this->form->isValid())
      {
        try{
          $this->form->save();
        }
        catch(Doctrine_Exception $ne)
        {
          $this->getUser()->setFlash('error', "The message you've tried to add already exists.");
        }
        $this->redirect('part/chooselang?part='.$this->part->getId());
      }
    }
  }
  
  public function executeMessagedelete(sfWebRequest $request)
  {
    $this->message = Doctrine::getTable('Message')->find($request->getParameter('id'));
    $part = $this->message->getPartId();
    if($request->hasParameter('confirm'))
    {
      
      $this->message->delete();
      $this->redirect('part/chooselang?part='.$part);
    }
    
  }
}
