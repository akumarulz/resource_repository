<?php
function loadinnerTemplate($fileName) {
ob_start();
require $fileName;
$contents = ob_get_clean();
return $contents;
}

function loadTemplate($fileName, $templateVars) {
extract($templateVars);
ob_start();
require $fileName;
$contents = ob_get_clean();
return $contents;
}
?>
