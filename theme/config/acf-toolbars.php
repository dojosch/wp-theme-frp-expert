<?php

add_filter('acf/fields/wysiwyg/toolbars', 'my_toolbars');
function my_toolbars($toolbars)
{
    // underline
    $toolbars['Underline Only'] = array();
    $toolbars['Underline Only'][1] = array('underline');

    // superscript
    $toolbars['Superscript Only'] = array();
    $toolbars['Superscript Only'][1] = array('superscript');

    // bold
    $toolbars['Bold Only'] = array();
    $toolbars['Bold Only'][1] = array('bold');
    return $toolbars;
}