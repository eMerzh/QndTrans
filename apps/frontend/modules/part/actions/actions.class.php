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

  public function executeImport(sfWebRequest $request)
  {
    $this->part = Doctrine::getTable('Part')->find($request->getParameter('part'));


    $this->form = new ImportForm();    
    if($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if($this->form->isValid())
      {
        $this->form->import($this->part);
        $this->getUser()->setFlash('info', "File imported");
        $this->redirect('part/chooselang?part='.$this->part->getId());
      }
    }
  }

  public function executeImporttrans(sfWebRequest $request)
  {
    $this->part = Doctrine::getTable('Part')->find($request->getParameter('part'));


    $this->form = new ImportTransForm();    
    if($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if($this->form->isValid())
      {
        $this->form->import($this->part);
        $this->getUser()->setFlash('info', "File imported");
        $this->redirect('part/chooselang?part='.$this->part->getId());
      }
    }
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
  public function executeManage(sfWebRequest $request)
  {
    $this->part = Doctrine::getTable('Part')->find($request->getParameter('part'));
    $this->msgs = Doctrine::getTable('Message')->findAll();
    /*$this->form =  new ManageMessagesForm(null,array('part' =>$this->part));
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('manage_part'));
    }*/
  }

  public function executeAdd(sfWebRequest $request)
  {
    $this->form = new PartForm();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('part'));
      if ($this->form->isValid())
      {
        try{
          $this->form->save();
        }
        catch(Doctrine_Exception $ne)
        {
          //$this->getUser()->setFlash('error', "The message you've tried to add already exists.");
        }
        $this->redirect('part/index');
      }
    }
  }
}
