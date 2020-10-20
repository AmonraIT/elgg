<?php
/**
 * FreiChat settings
 *
 * @package FreiChat
 */

$entity = elgg_extract('entity', $vars);

$token = $entity->token ?: '';
echo elgg_view_field([
    '#type' => 'text',
    '#label' => elgg_echo('freichat:settings:token'),
    '#help' => elgg_view_icon('help') . elgg_echo('freichat:settings:token:help'),
    'name' => 'params[token]',
    'value' => $token,
]);

$noyes_options = [
    'no' => elgg_echo('option:no'),
    'yes' => elgg_echo('option:yes'),
];

echo elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('freichat:settings:friends'),
    '#help' => elgg_echo('freichat:settings:friends:help'),
    'name' => 'params[friends]',
    'options_values' => $noyes_options,
    'value' => $entity->friends,
]);
