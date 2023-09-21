<?php
    return [
        '/' => 'CourseController@index',
        '/add' => 'CourseController@add',
        '/edit/{id}' => 'CourseController@edit',
        '/delete/{id}' => 'CourseController@delete',
    ];
?>
