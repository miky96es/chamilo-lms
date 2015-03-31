<?php
/* For licensing terms, see /license.txt */

/**
 * View (MVC patter) for editing an attendance
 * @author Christian Fasanando <christian1827@gmail.com>
 * @package chamilo.attendance
 */

// protect a course script
api_protect_course_script(true);

// error messages
if (isset($error)) {
    Display::display_error_message(get_lang('FormHasErrorsPleaseComplete'),false);
}

$param_gradebook = '';
if (isset($_SESSION['gradebook'])) {
    $param_gradebook = '&gradebook='.Security::remove_XSS($_SESSION['gradebook']);
}

if (!isset($error)) {
    $token = Security::get_token();
}

$attendance_weight = floatval($attendance_weight);
// display form
$form = new FormValidator('attendance_edit','POST','index.php?action=attendance_edit&'.api_get_cidreq().'&attendance_id='.$attendance_id.$param_gradebook);
$form->addElement('header', '', get_lang('Edit'));
$form->addElement('hidden', 'sec_token',$token);
$form->addElement('hidden', 'attendance_id', $attendance_id);

$form->addText('title', get_lang('Title'), true, array('size'=>'50'));
$form->applyFilter('title','html_filter');
$form->addHtmlEditor('description', get_lang('Description'), false, false, array('ToolbarSet' => 'TrainingDescription', 'Width' => '100%', 'Height' => '200'));

// Adavanced Parameters

if (Gradebook::is_active()) {
    if (!empty($attendance_qualify_title) || !empty($attendance_weight)) {
        $form->addButtonAdvancedSettings('id_qualify');
        $form->addElement('html','<div id="id_qualify_options" style="display:block">');
        $form->addElement('checkbox', 'attendance_qualify_gradebook', '', get_lang('QualifyAttendanceGradebook'),array('checked'=>'true','onclick'=>'javascript: if(this.checked){document.getElementById(\'options_field\').style.display = \'block\';}else{document.getElementById(\'options_field\').style.display = \'none\';}'));
        $form->addElement('html','<div id="options_field" style="display:block">');
    } else {
        $form->addButtonAdvancedSettings('id_qualify');
        $form->addElement('html','<div id="id_qualify_options" style="display:none">');
        $form->addElement('checkbox', 'attendance_qualify_gradebook', '', get_lang('QualifyAttendanceGradebook'),'onclick="javascript: if(this.checked){document.getElementById(\'options_field\').style.display = \'block\';}else{document.getElementById(\'options_field\').style.display = \'none\';}"');
        $form->addElement('html','<div id="options_field" style="display:none">');
    }
    GradebookUtils::load_gradebook_select_in_tool($form);
    $form->addElement('text', 'attendance_qualify_title', get_lang('TitleColumnGradebook'));
    $form->applyFilter('attendance_qualify_title', 'html_filter');
    $form->addElement('text', 'attendance_weight', get_lang('QualifyWeight'),'value="0.00" Style="width:40px" onfocus="javascript: this.select();"');
    $form->applyFilter('attendance_weight', 'html_filter');
    $form->addElement('html','</div>');

    $form->addElement('html','</div>');
}
$form->addButtonUpdate(get_lang('Save'));

// set default values
$default['title'] = Security::remove_XSS($title);
$default['description'] = Security::remove_XSS($description,STUDENT);
$default['attendance_qualify_title'] = $attendance_qualify_title;
$default['attendance_weight'] = $attendance_weight;

$link_info = GradebookUtils::is_resource_in_course_gradebook(api_get_course_id(), 7, $attendance_id, api_get_session_id());
$default['category_id'] = $link_info['category_id'];
$form->setDefaults($default);
$form->display();
