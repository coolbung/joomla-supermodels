<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Hello Table class
 *
 * @since  0.0.1
 */
class JTicketingTableEvent extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 */
	function __construct(&$db)
	{
		$this->setColumnAlias('published', 'state');
		parent::__construct('#__jticketing_events', 'id', $db);
	}
	
	function check()
	{
		$db = JFactory::getDbo();
		$errors = array();

		// Validate and create alias if needed
		$this->alias = trim($this->alias);
		if (!$this->alias)
		{
			$this->alias = $this->title;
		}

		if ($this->alias)
		{
			if (JFactory::getConfig()->get('unicodeslugs') == 1)
			{
				$this->alias = JFilterOutput::stringURLUnicodeSlug($this->alias);
			}
			else
			{
				$this->alias = JFilterOutput::stringURLSafe($this->alias);
			}
		}
		
		// Make sure creator is set
		if (!JFactory::getUser($this->created_by)->id)
		{
			$errors['created_by'] = 'Invalid Creator';
		}

		// End date should be later than start
		if (strtotime($this->event_start) > strtotime($this->event_end))
		{
			$errors['event_end'] = 'Invalid End Date';
		}
		
		if (count($errors))
		{
			$this->setError(implode($errors, ', '));
			return false;
		}
		
		return true;
	}
}
