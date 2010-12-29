/**
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
$(document).ready(function() {
 	$('#fMenu').fMenu();
});

function go_to (anchor) {

	var element = $('#fMenu').find("a[href*='"+ anchor +"']");
	element.parent().addClass("selected");
	
	$(element.parent().parent().parent()).children('a').click();
}