# Piklist Field Addons

[Piklist][0] is a Rapid Development Framework for WordPress. Learn more about Piklist at [http://piklist.com/user-guide/docs/][1]

- This plugin extends Piklist by creating a simple framework for adding additional field types to Piklist.

## Sample Usage

### Adding a [Select2][2] style select box

    piklist(‘field’, array(
		‘type’ => ‘select2′
		,’field’ => ‘select’
		,’label’ => ‘Select’
		,’value’ => ”
		,’choices’ => array(
			” => ”
			,’first’ => ‘First Choice’
			,’second’ => ‘Second Choice’
			,’third’ => ‘Third Choice’
		)
		,’options’ => array(
			‘allowClear’ => true
			,’placeholder’ => ‘Select an Option’
			,’width’ => ’200px’
		)
	));

### More field types to come

### [Fork me][3] to add more field types

### Copyright

Copyright 2013 Adam Anderly

### License

GPLv2

[0]:http://piklist.com
[1]:http://piklist.com/user-guide/docs/
[2]:http://ivaynberg.github.com/select2/
[3]:https://github.com/anderly/piklist-field-addons/fork_select