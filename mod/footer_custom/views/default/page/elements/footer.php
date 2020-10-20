<?php
echo elgg_view_menu('footer', ['sort_by' => 'priority', 'class' => 'elgg-menu-hz']);

echo elgg_format_element('div', ['class' => 'clearfloat elgg-menu-footer-default'], elgg_echo('my_plugin:copyright_text'));