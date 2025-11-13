<?php

    header("Content-Type: application/json");
    $data = ['name' => 'Mehedi', 'task' => 'Learn PHP'];
    echo json_encode($data);

    // echo "Mehedi Hasan Sawon";