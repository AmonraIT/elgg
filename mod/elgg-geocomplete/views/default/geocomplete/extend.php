
<script>
require(['elgg', 'jquery', 'geocomplete/geocomplete'], function (elgg, $, geocomplete) {

    $(function(){
        $(".elgg-input-location").geocomplete({ details: ".locinfo" });
      });
});

</script>


<?php
echo "<div class='locinfo'>";
echo elgg_view('input/hidden', array('name'=>'geo:lat'));
echo elgg_view('input/hidden', array('name'=>'geo:lng'));
echo "</div>";


