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
    $self_url = '@message_list';
    $self_url_param = '/part/'.$request->getParameter('part').'/lang/'.$request->getParameter('lang');
    $query = Doctrine::getTable('Message')->getMessagesForTranslation(
      $request->getParameter('part'),
      $request->getParameter('lang')
    );
    $this->currentPage = $request->getParameter('page', 1);
    $this->pagerLayout = new PagerLayoutWithArrows(
      new LazyPager(
        $query,
        $this->currentPage,
        2 //Number per pages
      ),
      new Doctrine_Pager_Range_Sliding(array('chunk' => 3)),
      $this->getController()->genUrl($self_url).$self_url_param.'/page/{%page_number}'
    );
    $this->pagerLayout->setTemplate('<li><a href="{%url}">{%page}</a></li>');
    $this->pagerLayout->setSelectedTemplate('<li>{%page}</li>');
    $this->pagerLayout->setSeparatorTemplate('<span class="pager_separator">::</span>');

    if (! $this->pagerLayout->getPager()->getExecuted())
      $this->messages = $this->pagerLayout->execute();


    $this->language = Doctrine::getTable('Language')->find($request->getParameter('lang'));
    $this->part = Doctrine::getTable('Part')->find($request->getParameter('part'));

    $this->translations = Doctrine::getTable('Translation')->getTranslationsForMessages($this->messages, $request->getParameter('lang'));

    $this->form = new TransPageForm(null,array(
      'messages' => $this->messages,
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
          $this->redirect('message/index?part='.$request->getParameter('part').'&lang='.$request->getParameter('lang').'&page='.$this->currentPage);
        }
        catch(Doctrine_Exception $ne)
        {
         // $this->form->getErrorSchema()->addError($error, 'Darwin2 :');
        }
      }
    }
  }
}
