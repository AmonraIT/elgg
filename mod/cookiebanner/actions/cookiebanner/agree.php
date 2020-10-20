<?php

// if visitor agreed set cookie that expires in 14 days
if (isset($_POST['btnCookieOk'])) {
   setcookie('eu-cookie', '1', time() + 1209600, '/');
}

return elgg_ok_response('', '', REFERER);
