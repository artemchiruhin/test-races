<?php
function get_data($file_path) {
    if(file_exists($file_path)) {
        $data = json_decode(file_get_contents($file_path), true);
        if(json_last_error() === JSON_ERROR_NONE) {
            return array_values($data);
        }
    }
    return [];
}

function sort_cars($sort_attempt, $cars) {
    $attempts = get_max_attempts($cars);
    if(is_int((int)$sort_attempt) && (int)$sort_attempt >= 1 && (int)$sort_attempt <= $attempts) {
        usort($cars, function($a, $b) use($sort_attempt) {
            return array_key_exists($sort_attempt - 1, $a['attempts']) && array_key_exists($sort_attempt - 1, $b['attempts']) ? $b['attempts'][$sort_attempt - 1]['result'] <=> $a['attempts'][$sort_attempt - 1]['result'] : 0;
        });
    } else {
        usort($cars, function($a, $b) {
            return $b['result'] <=> $a['result'];
        });
    }
    return $cars;
}

function get_cars_and_attempts($sort_attempt) {
    $cars = get_data(__DIR__ . '/../data/data_cars.json');
    $attempts = get_data(__DIR__ . '/../data/data_attempts.json');
    foreach($attempts as $attempt) {
        $id = array_search($attempt["id"], array_column($cars, "id"));
        $cars[$id]["attempts"][] = $attempt;
        if(array_key_exists("result", $cars[$id])) {
            $cars[$id]["result"] += $attempt["result"];
        } else {
            $cars[$id]["result"] = 0;
        }
    }
    return sort_cars($sort_attempt, $cars);
}

function get_max_attempts($cars) {
    $attempts = array_column($cars, 'attempts');
    if(count($attempts) === 0) {
        return 0;
    }
    return count(max($attempts));
}