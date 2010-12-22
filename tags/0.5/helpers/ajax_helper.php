<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Generates a link that can initiate AJAX requests.
	 * @param string the link body (it will NOT be HTML-encoded.)
	 * @param mixed the URL for the AJAX request. If empty, it is assumed to be the current URL. See {@link normalizeUrl} for more details.
	 * @param array AJAX options (see {@link ajax})
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated link
	 * @see normalizeUrl
	 * @see ajax
	 */
	function ajaxLink($text,$url,$ajaxOptions=array(),$htmlOptions=array())
	{
		/*<?php echo CHtml::ajaxLink('clickMe', array('ajax'), array('update'=>'#forAjaxRefresh'));?>*/
	}

	function ajaxButton($label,$url,$ajaxOptions=array(),$htmlOptions=array())
	{
		
		
	}
	/**
	 * Generates a push button that can submit the current form in POST method.
	 * @param string the button label
	 * @param mixed the URL for the AJAX request. If empty, it is assumed to be the current URL. See {@link normalizeUrl} for more details.
	 * @param array AJAX options (see {@link ajax})
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button
	 */
	function ajaxSubmitButton($label,$url,$ajaxOptions=array(),$htmlOptions=array())
	{
		/*<?php echo CHtml::ajaxSubmitButton(Yii::t('job','Create Job'),CHtml::normalizeUrl(array('job/addnew','render'=>false)),array('success'=>'js: function(data) {
                        $("#Person_jid").append(data);
                        $("#jobDialog").dialog("close");
                    }'),array('id'=>'closeJobDialog')); ?>
		*/
	}
	
	
	function ajax ($selector, $event,$ajaxOptions=array()) {
	
	}
	
	//checkbox
	//radio
	
	// ------------------------------------------------------------------------

	/**
	 * Form Error
	 *
	 * Returns the error for a specific form field.  This is a helper for the
	 * form validation class.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	if ( ! function_exists('form_error'))
	{
		function form_error($field = '', $prefix = '', $suffix = '')
		{
			if (FALSE === ($OBJ =& _get_validation_object()))
			{
				return '';
			}
	
			return $OBJ->error($field, $prefix, $suffix);
		}
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Validation Error String
	 *
	 * Returns all the errors associated with a form submission.  This is a helper
	 * function for the form validation class.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	if ( ! function_exists('validation_errors'))
	{
		function validation_errors($prefix = '', $suffix = '')
		{
			if (FALSE === ($OBJ =& _get_validation_object()))
			{
				return '';
			}
	
			return $OBJ->error_string($prefix, $suffix);
		}
	}