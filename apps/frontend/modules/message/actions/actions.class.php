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
    $this->translations = Doctrine::getTable('Translation')->getTranslationsForMessages($this->messages, $request->getParameter('lang'));

    $this->form = new TransPageForm(null,array(
      'messages'=>$this->messages,
      'translations' => $this->translations,
      'part_id' => $request->getParameter('part'),
      'lang_id' => $request->getParameter('lang')
    ));

    if($request->isMethod('post'))
    {
      $this->form->bind( $request->getParameter('translations') );
      if( $this->form->isValid() )
      {
        try
        {
          $this->form->save();
          $this->redirect('message/index?part='.$request->getParameter('part').'&lang='.$request->getParameter('lang'));
        }
        catch(Doctrine_Exception $ne)
        {
         // $this->form->getErrorSchema()->addError($error, 'Darwin2 :');
        }
      }
    }
  }
}
