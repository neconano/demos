<?php

//业务

// 设置热门课程
function set_course_hot($data, $right_button){
    $name = $right_button['name'];
    $new_right_button = $right_button[$name . $data['is_hot']];
    return $new_right_button;
}

// 设置最新课程
function set_course_new($data, $right_button){
    $name = $right_button['name'];
    $new_right_button = $right_button[$name . $data['is_new']];
    return $new_right_button;
}


