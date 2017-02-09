<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');
jimport('joomla.application.component.helper');
require_once JPATH_COMPONENT .'/builder/classes/base.php';
require_once JPATH_COMPONENT .'/builder/classes/config.php';

JHTML::_('behavior.keepalive');
JHtml::_('jquery.ui', array('core', 'sortable'));
JHtml::_('formbehavior.chosen', 'select');

$doc = JFactory::getDocument();
$doc->addScriptdeclaration('var pagebuilder_base="' . JURI::root() . '";');
$doc->addStylesheet( JURI::base(true) . '/components/com_sppagebuilder/assets/css/apps.css' );
$doc->addStylesheet( JURI::base(true) . '/components/com_sppagebuilder/assets/css/jquery.minicolors.css' );
$doc->addStylesheet( JURI::base(true) . '/components/com_sppagebuilder/assets/css/pbfont.css' );
$doc->addStylesheet( JURI::base(true) . '/components/com_sppagebuilder/assets/css/sppagebuilder.css' );

//js
$doc->addScript( JURI::root(true) . '/media/editors/tinymce/tinymce.min.js' );
$doc->addScript( JURI::base(true) . '/components/com_sppagebuilder/assets/js/jquery.minicolors.min.js' );
$doc->addScript( JURI::base(true) . '/components/com_sppagebuilder/assets/js/media.js' );
$doc->addScript( JURI::base(true) . '/components/com_sppagebuilder/assets/js/script.js' );
$doc->addScript( JURI::base(true) . '/components/com_sppagebuilder/assets/js/actions.js' );

require_once JPATH_ROOT . '/administrator/components/com_sppagebuilder/helpers/language.php';
$app = JFactory::getApplication();

global $pageId;
global $language;
global $pageLayout;

$pageId = $this->item->id;
$language = $this->item->language;

SpPgaeBuilderBase::loadAddons();
$addons_list    = SpAddonsConfig::$addons;
$new_addons     = array();
foreach ($addons_list as $key => $addon) {
  $new_addons[$key]['title'] = $addon['title'];
  $new_addons[$key]['icon'] = $addon['icon'];
}
$doc->addScriptdeclaration('var addonsJSON=' . json_encode($new_addons) . ';');


if (!$this->item->text) {
  $doc->addScriptdeclaration('var initialState=[];');
} else {
  require_once JPATH_COMPONENT . '/builder/classes/addon.php';
  $this->item->text = SpPageBuilderAddonHelper::__($this->item->text);
  $doc->addScriptdeclaration('var initialState=' . $this->item->text . ';');
}
?>


<div class="sp-pagebuilder-admin">

  <form action="#" method="post" name="adminForm" id="adminForm" class="form-validate">

   <div class="clearfix sp-page-header">
    <div class="pull-left">
     <?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
   </div>
   <div class="pull-right">
     <div class="text-right">
      <div class="sp-pagebuilder-btn-group">
       <a href="#" id="btn-save-page" class="sp-pagebuilder-btn sp-pagebuilder-btn-success"><i class="fa fa-save"></i> <?php echo JText::_('COM_SPPAGEBUILDER_SAVE'); ?></a>
       <a href="#" class="sp-pagebuilder-btn sp-pagebuilder-btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></a>
       <ul class="dropdown-menu">
        <li><a id="btn-save-close" href="#"><i class="fa fa-check"></i> <?php echo JText::_('COM_SPPAGEBUILDER_SAVE_CLOSE'); ?></a></li>
        <li><a id="btn-save-new" href="#"><i class="fa fa-plus"></i> <?php echo JText::_('COM_SPPAGEBUILDER_SAVE_NEW'); ?></a></li>
        <li><a id="btn-save-copy" href="#"><i class="fa fa-clone"></i> <?php echo JText::_('COM_SPPAGEBUILDER_SAVE_COPY'); ?></a></li>
      </ul>
    </div>

    <?php if($this->item->id) { ?>
      <div class="sp-pagebuilder-btn-group">
        <a id="btn-page-frontend-editor" target="_blank" href="javascript:;" class="sp-pagebuilder-btn sp-pagebuilder-btn-info"><i class="fa fa-edit"></i> <?php echo JText::_('COM_SPPAGEBUILDER_FRONTEND_EDITOR'); ?> <small>(PRO)</small></a>
      </div>

      <div class="sp-pagebuilder-btn-group">
        <a id="btn-page-preview" target="_blank" href="<?php echo JURI::root(true); ?>/index.php?option=com_sppagebuilder&amp;view=page&amp;id=<?php echo $this->item->id; ?>" class="sp-pagebuilder-btn sp-pagebuilder-btn-inverse"><i class="fa fa-eye"></i> <?php echo JText::_('COM_SPPAGEBUILDER_PREVIEW'); ?></a>
      </div>
    <?php } ?>

    <div class="sp-pagebuilder-btn-group">
     <a href="#" id="btn-page-options" class="sp-pagebuilder-btn sp-pagebuilder-btn-inverse"><i class="fa fa-gear"></i> <?php echo JText::_('COM_SPPAGEBUILDER_OPTIONS'); ?></a>
   </div>

   <div class="sp-pagebuilder-btn-group">
     <a href="#" class="sp-pagebuilder-btn sp-pagebuilder-btn-inverse" onclick="Joomla.submitbutton('page.cancel')"><i class="fa fa-times"></i> <?php echo JText::_('COM_SPPAGEBUILDER_CLOSE'); ?></a>
   </div>
 </div>
</div>
</div>

<div id="sp-pagebuilder-page-tools" class="clearfix sp-pagebuilder-page-tools">
</div>

<div class="form-horizontal">
  <div class="row-fluid">
    <div class="span12">
      <?php
      $fields = $this->form->getFieldset('basic');
      foreach ($fields as $key => $field) {
        if (($field->name == 'jform[text]') || ($field->name == 'jform[id]')) {
          ?>
          <div class="control-group hidden">
            <div class="control-label"><?php echo $field->label; ?></div>
            <div class="controls"><?php echo $field->input; ?></div>
          </div>
          <?php
        }
      }
      ?>
      <div id="container"></div>
    </div>
  </div>
</div>


<div class="sp-pagebuilder-modal-alt">
  <div id="page-options" class="sp-pagebuilder-modal-overlay" style="position:fixed;top:0;left:0;right:0;bottom:0;">
    <div class="sp-pagebuilder-modal-content" style="position:fixed;top:0px;left:0px;right:0px;bottom:0px;">
      <div class="sp-pagebuilder-modal-small">
       <h2 class="sp-pagebuilder-modal-title"><?php echo JText::_('COM_SPPAGEBUILDER_PAGE_OPTIONS'); ?></h2>
       <div>
        <div class="page-options-content">

          <?php
          $fieldsets = $this->form->getFieldsets();
          ?>

          <ul class="sp-pagebuilder-nav sp-pagebuilder-nav-tabs" id="pageTabs">
            <li class="active"><a href="#seosettings" data-toggle="tab"><i class="fa fa-bullseye"></i> <?php echo JText::_($fieldsets['seosettings']->label, true); ?></a></li>
            <li><a href="#pagecss" data-toggle="tab"><i class="fa fa-css3"></i> <?php echo JText::_($fieldsets['pagecss']->label, true); ?></a></li>
            <li><a href="#publishing" data-toggle="tab"><i class="fa fa-calendar-check-o"></i> <?php echo JText::_($fieldsets['publishing']->label, true); ?></a></li>
          </ul>

          <div class="tab-content" id="pageContent">

            <div id="seosettings" class="tab-pane active">
              <?php foreach ($this->form->getFieldset('seosettings') as $key => $field) { ?>
                <div class="sp-pagebuilder-form-group">
                  <?php echo $field->label; ?>
                  <?php echo str_replace(array('<input', '<textarea'), array('<input class="sp-pagebuilder-form-control"', '<textarea class="sp-pagebuilder-form-control"'), $field->input); ?>
                </div>
                <?php } ?>
              </div>

              <div id="pagecss" class="tab-pane">
                <?php foreach ($this->form->getFieldset('pagecss') as $key => $field) { ?>
                  <div class="sp-pagebuilder-form-group">
                    <?php echo $field->label; ?>
                    <?php echo str_replace(array('<textarea'), array('<textarea class="sp-pagebuilder-form-control"'), $field->input); ?>
                  </div>
                  <?php } ?>
                </div>

                <div id="publishing" class="tab-pane">
                  <?php foreach ($this->form->getFieldset('publishing') as $key => $field) { ?>
                    <div class="sp-pagebuilder-form-group">
                      <?php echo $field->label; ?>
                      <?php echo str_replace(array('<input', '<textarea'), array('<input class="sp-pagebuilder-form-control"', '<textarea class="sp-pagebuilder-form-control"'), $field->input); ?>
                    </div>
                    <?php } ?>
                  </div>

                </div>

                <a id="btn-apply-page-options" class="sp-pagebuilder-btn sp-pagebuilder-btn-success" href="#"><i class="fa fa-check-square-o"></i> <?php echo JText::_('COM_SPPAGEBUILDER_APPLY'); ?></a>
                <a id="btn-cancel-page-options" class="sp-pagebuilder-btn sp-pagebuilder-btn-default" href="#"><i class="fa fa-times-circle-o"></i> <?php echo JText::_('COM_SPPAGEBUILDER_CANCEL'); ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php echo JLayoutHelper::render('footer'); ?>

    <input type="hidden" id="form_task" name="task" value="page.apply" />
    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>

<script type="text/javascript" src="<?php echo JURI::base(true) . '/components/com_sppagebuilder/assets/js/engine.js'; ?>"></script>
