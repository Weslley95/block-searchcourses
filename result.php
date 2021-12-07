<?php

global $CFG;

require_once('../../config.php');
require_once($CFG->libdir . '/datalib.php');

require_login();

if(!defined('AJAX_SCRIPT')){
    define('AJAX_SCRIPT', true);
}

$query            = $_GET['query'];
$courses['query'] = $query;

// Takes all user courses
$courses['results'] = enrol_get_my_courses(array('id', 'shortname'), 'visible DESC,sortorder ASC');

//Once you have the results, filter the ones matching the search query
$mycourses = array();
foreach ($courses['results'] as $objCourse) {
    if (preg_match('/' . $query . '/i', $objCourse->fullname) != 0) {
        $mycourses[] = $objCourse;
    }
}

$courses['results'] = array_values($mycourses);
echo json_encode($courses);
