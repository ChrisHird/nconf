<?php
echo '
    <h2 class="ui-widget-header header"><span>'.TXT_MENU_MISC.'</span></h2>
    <div class="ui-widget-content box_content">';

        ###

        $misc_menu_begin = array();
        array_push($misc_menu_begin, array("nav_links" => "Show History::history.php", "friendly_name" => "", "grouping" => ""));
        array_push($misc_menu_begin, array("nav_links" => "Show Host parent / child view::dependency.php", "friendly_name" => "", "grouping" => ""));
        array_push($misc_menu_begin, array("nav_links" => "Legal Disclaimer::legal.php", "friendly_name" => "", "grouping" => ""));
        create_menu($misc_menu_begin);

echo '</div>';

// FIX menu user end
//include('include/menu/static_content/menu_user_end.php');
include('include/menu/static_content/menu_user_end.html');

?>
