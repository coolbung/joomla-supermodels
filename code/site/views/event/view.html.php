<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jticketing
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

JLoader::import('joomla.application.component.model');
JLoader::import( 'event', JPATH_ADMINISTRATOR . '/components/com_jticketing/models' );

class JTicketingViewEvent extends JViewLegacy
{
	public function display($tpl = null)
	{
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		$item_model = JModelLegacy::getInstance( 'event', 'JTicketingModel' );
		$this->item		= $item_model->getItem();
		
		$item_model->hit($this->item->id);

		// Display the template
		parent::display($tpl);
	}
}
