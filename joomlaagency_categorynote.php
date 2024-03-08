<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

class PlgContentJoomlaAgency_CategoryNote extends CMSPlugin
{
    protected $autoloadLanguage = true;

    public function onContentPrepareForm($form, $data)
    {
        if ($form->getName() === 'com_content.article' && isset($data->catid))
        {
            $fieldId = (int) $this->params->get('category_note_field', 0);

            if ($fieldId > 0)
            {
                $db = Factory::getDbo();
                $query = $db->getQuery(true)
                    ->select($db->quoteName('value'))
                    ->from($db->quoteName('#__fields_values'))
                    ->where($db->quoteName('field_id') . ' = ' . $fieldId)
                    ->where($db->quoteName('item_id') . ' = ' . (int) $data->catid);
                $db->setQuery($query);
                $categoryNote = $db->loadResult();

                if ($categoryNote)
                {
                    Factory::getApplication()->enqueueMessage(Text::_($categoryNote), 'notice');
                }
            }
        }

        return true;
    }
}
