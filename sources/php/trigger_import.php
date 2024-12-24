<?php
$dataImportPath = __DIR__ . '/data_import.php';

$output = [];
$return_var = 0;
exec("php $dataImportPath", $output, $return_var);

if ($return_var === 0) {
    echo "<h1>Data Import Completed Successfully!</h1>";
    echo "<pre>" . implode("\n", $output) . "</pre>";
} else {
    echo "<h1>Data Import Failed!</h1>";
    echo "<pre>" . implode("\n", $output) . "</pre>";
}
?>