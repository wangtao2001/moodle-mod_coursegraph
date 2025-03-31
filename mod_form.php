<?php
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/moodleform_mod.php');

// 课程知识图谱表单
class mod_coursegraph_mod_form extends moodleform_mod
{
    public function definition()
    {
        $mform = $this->_form;

        // 添加标题字段, 对应 db 中的 name 字段
        $mform->addElement('text', 'name', get_string('coursegraphname', 'coursegraph'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        // 添加服务器URL字段, 对应 db 中的 serverurl 字段
        $mform->addElement('text', 'serverurl', get_string('serverurl', 'coursegraph'));
        $mform->setType('serverurl', PARAM_URL);
        $mform->addRule('serverurl', null, 'required', null, 'client');
        $mform->addHelpButton('serverurl', 'serverurl', 'coursegraph');

        // 添加API key字段, 对应 db 中的 apikey 字段
        $mform->addElement('text', 'apikey', get_string('apikey', 'coursegraph'));
        $mform->setType('apikey', PARAM_TEXT);
        $mform->addRule('apikey', null, 'required', null, 'client');
        $mform->addHelpButton('apikey', 'apikey', 'coursegraph');

        // 添加标准简介字段, 对应 db 中的 intro 字段
        $this->standard_intro_elements();

        // 添加标准课程模块元素
        $this->standard_coursemodule_elements();

        // 添加提交按钮
        $this->add_action_buttons();
    }
}
