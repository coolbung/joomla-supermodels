# Joomla Supermodels
Various use cases for using Joomla models in a flexible way

These files are part of the presentation at


## Using Models in modules or any other place

```php
<?php
JLoader::import('components.com_jticketing.models.events', JPATH_ADMINISTRATOR);
JLoader::import('components.com_jticketing.models.event', JPATH_ADMINISTRATOR);
JLoader::import('components.com_jticketing.tables.event', JPATH_ADMINISTRATOR);

$items_model = JModelLegacy::getInstance('events', 'JTicketingModel');
$item_model = JModelLegacy::getInstance('event', 'JTicketingModel');

$items_model->setState('filter.state', 1);
//$items_model->setState('filter.start_up', '2016-10-24');
$items = $items_model->getItems();

$single_item = $item_model->getItem(4);

print_r($single_item);
print_r($items);
```
