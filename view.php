<?php

require('../../config.php');
require_once("$CFG->dirroot/mod/coursegraph/lib.php");

$id = required_param('id', PARAM_INT); // 课程 id, 从 url 中获取

if (!$cm = get_coursemodule_from_id('coursegraph', $id)) { // 从课程 id 获取课程模块且需要是 coursegraph 类型
    throw new moodle_exception('invalidcoursemodule');
}
if (!$course = $DB->get_record('course', array('id' => $cm->course))) { // 获取课程
    throw new moodle_exception('coursemisconf');
}
if (!$coursegraph = $DB->get_record('coursegraph', array('id' => $cm->instance))) { // 获取当前 coursegraph 实例
    throw new moodle_exception('invalidid', 'coursegraph');
}

require_login($course, true, $cm);


$PAGE->set_url('/mod/coursegraph/view.php', array('id' => $cm->id)); // 设置 url 附带 id 参数
$PAGE->set_title(format_string($coursegraph->name)); // 设置页面标题
$PAGE->set_heading(format_string($course->fullname)); // 设置页面头部

$PAGE->requires->css('/mod/coursegraph/amd/src/index.css');
$PAGE->requires->js_call_amd('mod_coursegraph/index', 'init', [
    'serverUrl' => $coursegraph->serverurl,
    'apiKey' => $coursegraph->apikey
]);

echo $OUTPUT->header();
?>
<div id="app">
</div>
<?php
echo $OUTPUT->footer($course);
