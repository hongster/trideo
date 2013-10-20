<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Helper
 */
class My_Form {

	/**
	 * Display label, input, error message, help message into a group.
	 * 
	 * @param string $input HTML string of input
	 * @param array $options
	 *	- group_attrs array Additional HTML attributes for form group.
	 *	- label_attrs array Additional HTML attributes for label.
	 *	- label string Label text.
	 *	- name string Field name.
	 *	- errors array Validation error messages.
	 *	- help_msg string Optional help message displayed under input.
	 * @return string
	 */
	public static function form_group($input, array $options)
	{
		$options = array_merge(array(
				'group_attrs' => array('class' => 'form-group'),
				'label_attrs' => array('class' => 'control-label'),
				'label' => FALSE,
				'name' => '',
				'help_msg' => FALSE,
				'errors' => array(),
			), $options);

		if ($error = Arr::get($options['errors'], $options['name']))
		{
			isset($options['group_attrs']['class']) OR $options['group_attrs']['class'] = '';
			$options['group_attrs']['class'] .= ' has-error'; 
		}

		$output = '<div'.HTML::attributes($options['group_attrs']).'>';
		
		if ($options['label'])
		{
			$output .= Form::label($options['name'], $options['label'], $options['label_attrs']);
		}

		$output .= $input;

		if ($error)
		{
			$output .= '<div class="help-block">'.HTML::chars(ucfirst($error)).'</div>';
		}

		if ($options['help_msg'])
		{
			$output .= '<div class="help-block">'.$options['help_msg'].'</div>';
		}

		$output .= '</div>';

		return $output;
	}

	/**
	 * 
	 * @param array $options
	 *	- group_attrs array Additional HTML attributes for form group.
	 *	- label_attrs array Additional HTML attributes for label.
	 *	- label string Label text.
	 * 	- input_attrs array Additional HTML attributes for input.
	 *	- name string Field name.
	 *	- data array Input data.
	 *	- errors array Validation error messages.
	 *	- help_msg string Optional help message displayed under input.
	 * @return string
	 */
	public static function input(array $options)
	{
		$name = Arr::get($options, 'name', '');
		$attributes = array_merge(array(
				'id' => $name,
				'class' => 'form-control',
			), Arr::get($options, 'input_attrs', array()));

		$input = Form::input($name, Arr::path($options, "data.{$name}"), $attributes);

		return static::form_group($input, $options);
	}

	/**
	 * 
	 * @param array $options
	 *	- group_attrs array Additional HTML attributes for form group.
	 *	- label_attrs array Additional HTML attributes for label.
	 *	- label string Label text.
	 * 	- input_attrs array Additional HTML attributes for input.
	 *	- name string Field name.
	 *	- data array Input data.
	 *	- errors array Validation error messages.
	 *	- help_msg string Optional help message displayed under input.
	 * @return string
	 */
	public static function password(array $options)
	{
		$name = Arr::get($options, 'name', '');
		$attributes = array_merge(array(
				'id' => $name,
				'class' => 'form-control',
				'type' => 'password'
			), Arr::get($options, 'input_attrs', array()));

		$input = Form::input($name, Arr::path($options, "data.{$name}"), $attributes);

		return static::form_group($input, $options);
	}

	/**
	 * @param string $name Input name.
	 * @param string $data Data array containing the input value.
	 * @param array $attributes HTML attributes.
	 * @return string
	 */
	public static function hidden($name, $data = array(), array $attributes = array())
	{
		$value = Arr::get($data, $name, NULL);
		$attributes = array_merge(array('id' => $name), $attributes);

		return Form::hidden($name, $value, $attributes);
	}

	/**
	 * 
	 * @param array $options
	 *	- group_attrs array Additional HTML attributes for form group.
	 *	- label_attrs array Additional HTML attributes for label.
	 *	- label string Label text.
	 * 	- input_attrs array Additional HTML attributes for textarea.
	 *	- name string Field name.
	 *	- data array Input data.
	 *	- errors array Validation error messages.
	 *	- help_msg string Optional help message displayed under input.
	 * @return string
	 */
	public static function textarea(array $options)
	{
		$name = Arr::get($options, 'name', '');
		$attributes = array_merge(array(
				'id' => $name,
				'class' => 'form-control',
			), Arr::get($options, 'input_attrs', array()));

		$input = Form::textarea($name, Arr::path($options, "data.{$name}"), $attributes);

		return static::form_group($input, $options);
	}

	/**
	 * 
	 * @param array $options
	 *	- selections array Select options.
	 *	- group_attrs array Additional HTML attributes for form group.
	 *	- label_attrs array Additional HTML attributes for label.
	 *	- label string Label text.
	 * 	- input_attrs array Additional HTML attributes for select element.
	 *	- name string Field name.
	 *	- data array Input data.
	 *	- errors array Validation error messages.
	 *	- help_msg string Optional help message displayed under input.
	 * @return string
	 */
	public static function select(array $options)
	{
		$name = Arr::get($options, 'name', '');
		$attributes = array_merge(array(
				'id' => $name,
				'class' => 'form-control',
			), Arr::get($options, 'input_attrs', array()));

		$input = Form::select($name, Arr::get($options, 'selections'), Arr::path($options, "data.{$name}"), $attributes);

		return static::form_group($input, $options);
	}

} // My_Form