<?php
/**
 * @version    SVN: <svn_id>
 * @package    com_jticketing
 * @copyright  Copyright (C) 2005 - 2014. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * Shika is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// No direct access.
defined('_JEXEC') or die;


// Add Table Path
JTable::addIncludePath(JPATH_ROOT . '/administrator/components/com_jticketing/tables');

/**
 * Routing class from com_jticketing
 *
 * @subpackage  com_jticketing
 *
 * @since       1.0.0
 */
class JTicketingRouter extends JComponentRouterBase
{
	// Array containing the 'known' views that the component will handle
	private  $views = array('buy','category','certificate','orders','event');

	/* These are the views that dont have the view name in the SEF URL
	 * Eg instead of /event/<event alias> they will just have /<event alias>
	 * Or instead of /events/<category alias> will directly have /<category alias>
	 * A check is made to find if the alias is a category or event alias and
	 * the apropriate query variables are set
	 */ 
	private  $special_views = array('events', 'event');

	// Array of views that need a event id in the URL
	// Eg event details, buy ticket etc
	private  $views_needing_id = array('buy', 'event');

	// Views that load in tmpl=component
	private  $views_needing_tmpl = array('certificate');

	/**
	 * Build the route for the com_jticketing component
	 *
	 * @param   array  &$query  An array of URL arguments
	 *
	 * @return  array  The URL arguments to use to assemble the subsequent URL.
	 *
	 * @since   1.0.0
	 */
	public function build(&$query)
	{
		$segments = array();

		// Get a menu item based on Itemid or currently active
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		$params = JComponentHelper::getParams('com_jticketing');
		$db = JFactory::getDbo();

		// We need a menu item.  Either the one specified in the query, or the current active one if none specified
		if (empty($query['Itemid']))
		{
			$menuItem = $menu->getActive();
			$menuItemGiven = false;
		}
		else
		{
			$menuItem = $menu->getItem($query['Itemid']);
			$menuItemGiven = true;
		}

		// Check again
		if ($menuItemGiven && isset($menuItem) && $menuItem->component != 'com_jticketing')
		{
			$menuItemGiven = false;
			unset($query['Itemid']);
		}

		// Check if view is set.
		if (isset($query['view']))
		{
			$view = $query['view'];
		}
		else
		{
			// We need to have a view in the query or it is an invalid URL
			return $segments;
		}

		// Add the view only for normal views, for special its just the slug
		if (isset($query['view']) && !in_array($query['view'], $this->special_views))
		{
			$segments[] = $query['view'];
			unset($query['view']);
		}

		/* Handle the special views */
		if ($view == 'events' && isset($query['filter_cat']))
		{
			$catId = (int) $query['filter_cat'];

			if ($catId)
			{
				$category = JTable::getInstance('Category', 'JTable', array('dbo', $db));
				$category->load(array('id' => $catId, 'extension' => 'com_jticketing'));

				$segments[] = $category->alias;
				unset($query['filter_cat']);
				unset($query['view']);
			}
		}

		if ($view == 'event')
		{
			if (isset($query['id']))
			{
				$events_table = $this->_getventRow($query['id'], 'id');

				$segments[] = $events_table->alias;
				unset($query['id']);
				unset($query['view']);
			}
		}
		/* End Handle the special views */

		/* Handle normal views */
		if ($view == 'orders')
		{
			if (isset($query['orderid']))
			{
				$segments[] = $query['orderid'];
				unset($query['orderid']);
			}
		}

		if (in_array($view, $this->views_needing_id) && isset($query['id']))
		{
			$event_table = $this->_getEventRow($query['id'], 'id');

			$segments[] = $event_table->alias;
			unset($query['id']);
		}
		/* End Handle normal views */

		// Hide tmpl=component from URLs that reply on it so users 
		// see a nicer URL
		if (in_array($view, $this->views_needing_tmpl))
		{
			unset($query['tmpl']);
		}

		return $segments;
	}

	/**
	 * Parse the segments of a URL.
	 *
	 * @param   array  &$segments  The segments of the URL to parse.
	 *
	 * @return  array  The URL attributes to be used by the application.
	 *
	 * @since   3.3
	 */
	public function parse(&$segments)
	{
		$item = $this->menu->getActive();
		$vars = array();
		$db = JFactory::getDbo();

		// Count route segments
		$count = count($segments);

		/*
		 * count = 1 : event / category or non-querystring needing views
		 */
		if ($count == 1)
		{
			$category_table = JTable::getInstance('Category', 'JTable', array('dbo', $db));
			$category_table->load(array('alias' => $segments[0], 'extension' => 'com_jticketing'));

			if ($category_table->id)
			{
				$vars['view'] = 'events';
				$vars['filter_cat'] = $category_table->id;
			}
			elseif ($eventtable_id = $this->_getEventRow($segments[0])->id)
			{
				$vars['view'] = 'event';
				$vars['id'] = $event_table_id;
			}
			elseif (in_array($segments[0], $this->views))
			{
				$vars['view'] = $segments[0];
			}
			else
			{
				/*
				 * If we dont get a valid category or event alias, or a
				 * valid view set set the variables to a non-existing
				 * event id and ensure that the view throws a 404 for a 
				 * non exiting event
				 */
				$vars['view'] = 'event';
				$vars['id'] = 0;
			}
		}
		else
		{
			$vars['view'] = $segments[0];

			switch ($segments[0])
			{
				case 'orders':
				if (isset($segments[1]))
				{
					$vars['orderid'] = $segments[1];
				}
				break;

				default:
				if (in_array($segments[0], $this->views_needing_id))
				{
					$event_table = $this->_getEventRow($segments[1]);

					$vars['id'] = $event_table->id;
				}
				break;
			}

			if (in_array($segments[0], $this->views_needing_tmpl))
			{
				$vars['tmpl'] = 'component';
			}
		}

		return $vars;
	}

	/**
	 * Get a event row based on alias or id
	 *
	 * @param   mixed   $event  The id or alias of the event to be loaded
	 * @param   string  $input   The field to match to load the event
	 *
	 * @return  object  The event JTable object
	 */
	private function _getEventRow($event, $input = 'alias')
	{
		$db = JFactory::getDbo();
		$table = JTable::getInstance('Event', 'JticketingTable', array('dbo', $db));
		$table->load(array($input => $event));

		return $table;
	}
}
