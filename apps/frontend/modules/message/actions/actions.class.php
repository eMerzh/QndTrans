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
  public function executeXliff(sfWebRequest $request)
  {
    $query = Doctrine::getTable('Message')->getMessagesForTranslation(
      $request->getParameter('part'),
      $request->getParameter('lang')
    );
    $this->messages = $query->execute();
    $this->language = Doctrine::getTable('Language')->find($request->getParameter('lang'));
    $this->part = Doctrine::getTable('Part')->find($request->getParameter('part'));

    $this->translations = Doctrine::getTable('Translation')->getTranslationsForMessages($this->messages, $request->getParameter('lang'));
    $request->setRequestFormat('xml');
  }
  
  public function executeAcceptTranslations(sfWebRequest $request)
  {
    $web_req = $request->getParameter('translations');
    $ids = explode('.',$web_req['msg_ids']);

    $this->form = new TransPageForm(null,array(
      'translations' =>  Doctrine::getTable('Translation')->searchByIds($ids),
      'part_id' => $request->getParameter('part'),
      'lang_id' => $request->getParameter('lang')
    ));
    $this->form->bind($web_req);
      if( $this->form->isValid() )
      {
        try
        {
          $this->form->save();
          $url = $this->getController()->genUrl('message/index?part='.$request->getParameter('part').'&lang='.$request->getParameter('lang').'&page='.$this->currentPage)
            .'?'.http_build_query( unserialize( $this->form->getValue('req')) );
          $this->redirect($url);
        }
        catch(Doctrine_Exception $ne)
        {
          //Do something!
        }
      }
    return $this->renderText('Error');
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->language = Doctrine::getTable('Language')->find($request->getParameter('lang'));
    $this->part = Doctrine::getTable('Part')->find($request->getParameter('part'));

    ///Insert Missing Translations
    Doctrine::getTable('Translation')->completeTranslationsFor($this->part, $this->language);

    $web_request = $request->isMethod('post') ? $request->getPostParameters() : $request->getGetParameters();
    if(!isset($web_request['translation_filters'])) $web_request['translation_filters'] =array('rec_per_page'=>10);
    $this->search_form = new TranslationFormFilter(null,array('lang' =>$this->language,'part'=> $this->part));
    unset($this->search_form[$this->search_form->getCSRFFieldName()]);

    $this->search_form->bind($web_request['translation_filters']);
    if ($this->search_form->isValid())
    {
      $query = $this->search_form->getQuery();
      $query->orderBy('m.created_at asc,id asc');

      $this->currentPage = $this->search_form->getValue('current_page');
      $this->pagerLayout = new PagerLayoutWithArrows(
        new LazyPager(
          $query,
          $this->currentPage,
          $this->search_form->getValue('rec_per_page') //Number per pages
        ),
        new Doctrine_Pager_Range_Sliding(array('chunk' => 3)),
        $this->getController()->genUrl('message/index?part='.$request->getParameter('part').'&lang='.$request->getParameter('lang')).'/page/{%page_number}'
      );
      $this->pagerLayout->setTemplate('<li data-page="{%page_number}"><a href="{%url}">{%page}</a></li>');
      $this->pagerLayout->setSelectedTemplate('<li>{%page}</li>');
      $this->pagerLayout->setSeparatorTemplate('<span class="pager_separator">::</span>');

      if (! $this->pagerLayout->getPager()->getExecuted())
        $this->translations = $this->pagerLayout->execute();
      
      $this->form = new TransPageForm(null,array(
        'translations' => $this->translations,
        'part_id' => $request->getParameter('part'),
        'lang_id' => $request->getParameter('lang'),
        'request' => $web_request,
      ));

    }
  }

  public function executeDelete(sfWebRequest $request)
  {
    if($request->hasParameter('id'))
    {
      $this->message = Doctrine::getTable('Message')->find($request->getParameter('id'));
      $part = $this->message->getPartId();
      if($request->hasParameter('confirm'))
      {
        $this->message->delete();
        $this->redirect('part/chooselang?part='.$part);
      }
    }
    elseif($request->hasParameter('ids'))
    {
      $ids = explode('.',$request->getParameter('ids'));
      Doctrine::getTable('Message')->deleteIn($ids);
      $this->redirect('part/manage?part='.$request->getParameter('part_id'));
    }
  }
}
