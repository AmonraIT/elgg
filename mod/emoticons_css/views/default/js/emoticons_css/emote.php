<?php
/**
 * emoticons_css JS
 */
?>
 // <script>
function elgg_emoticonize(){
    $('.elgg-output, .elgg-river-message,.elgg-full-comment-text, .elgg-comment-text, .elgg-input-plaintext, .messages-subject, .elgg-breadcrumbs li, .elgg-heading.main').emoticonize({
         //delay: 8000,
        //animate: false,
        //exclude: 'pre, code, .no-emoticons'
       });
   return true;
}
 
$(document).ready(function(){
    elgg_emoticonize();
});

