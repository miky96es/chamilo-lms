<?php
/* For licensing terms, see /license.txt */

require_once __DIR__.'/../inc/global.inc.php';

api_protect_course_script(true);

Event::event_access_tool(TOOL_CHAT);

$htmlHeadXtra[] = api_get_css_asset('emojione/assets/css/emojione.min.css');
$htmlHeadXtra[] = api_get_css_asset('emojionearea/dist/emojionearea.css');
$htmlHeadXtra[] = api_get_css_asset('highlight.js.origin/src/styles/github.css');
$htmlHeadXtra[] = api_get_css('css/chat.css');
$htmlHeadXtra[] = api_get_css('css/markdown.css');
$htmlHeadXtra[] = api_get_asset('highlight.js.origin/src/highlight.js');
$htmlHeadXtra[] = api_get_asset('jquery-textcomplete/dist/jquery.textcomplete.js');
$htmlHeadXtra[] = api_get_asset('emojionearea/dist/emojionearea.js');
$htmlHeadXtra[] = api_get_asset('emojione/lib/js/emojione.min.js');

$iconList = [];

foreach (Emojione\Emojione::$shortcode_replace as $key => $icon) {
    if (!in_array($key, CourseChatUtils::getEmojisToInclude())) {
        continue;
    }

    $iconList[$key] = strtoupper($icon).'.png';
}

$view = new Template(get_lang('Chat'), false, false, false, true, false);
$view->assign('icons', $iconList);
$view->assign('emoji_strategy', CourseChatUtils::getEmojiStrategry());
$view->assign('emoji_smile', \Emojione\Emojione::toImage(':smile:'));

$template = $view->get_template('chat/chat.tpl');
$content = $view->fetch($template);

$view->assign('content', $content);
$view->display_no_layout_template();
