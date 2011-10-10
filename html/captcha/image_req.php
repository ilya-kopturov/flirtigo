<?php

// Echo the image - timestamp appended to prevent caching
echo '<a href="javascript:;" onclick="refreshimg(); return false;" title="Click to refresh the image"><img src="/captcha/images/image.jpg?' . time() . '" width="132" height="46" alt="Loading..." title="Click me to refresh"></a>';

?>