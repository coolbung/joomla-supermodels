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

JHtml::_('formbehavior.chosen', 'select');

$listOrder     = $this->state->get('list.ordering');
$listDirn      = $this->state->get('list.direction');
?>
<form action="index.php?option=com_jticketing&view=events" method="post" id="adminForm" name="adminForm">
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%"></th>
			<th width="2%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>)" />
			</th>
			<th width="60%">
				<?php echo JHtml::_('grid.sort', 'Event Name', 'title', $listDirn, $listOrder);?>
			</th>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'Event Start', 'start_date', $listDirn, $listOrder);?>
			</th>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'Event End', 'end_date', $listDirn, $listOrder);?>
			</th>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'Creator', 'created_by', $listDirn, $listOrder);?>
			</th>
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'State', 'published', $listDirn, $listOrder); ?>
			</th>
			<th width="2%">
				<?php echo JHtml::_('grid.sort', 'Event ID', 'id', $listDirn, $listOrder); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) :
					$link = JRoute::_('index.php?option=com_jticketing&task=event.edit&id=' . $row->id);
				?>
					<tr>
						<td><?php echo $this->pagination->getRowOffset($i); ?></td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td>
							<a href="<?php echo $link; ?>" title="<?php echo JText::_('com_jticketing_EDIT_HELLOWORLD'); ?>">
								<?php echo $row->title; ?>
							</a>
						</td>
						<td align="center">
							<?php echo JHtml::date($row->event_start); ?>
						</td>
						<td align="center">
							<?php echo JHtml::date($row->event_end); ?>
						</td>
						<td align="center">
							<?php echo JFactory::getUser($row->created_by)->name; ?>
						</td>
						<td align="center">
							<?php echo JHtml::_('jgrid.published', $row->state, $i, 'events.', true, 'cb'); ?>
						</td>
						<td align="center">
							<?php echo $row->id; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

