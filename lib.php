<?php
defined('MOODLE_INTERNAL') || die();

function coursegraph_add_instance($coursegraph)
{
    global $DB;

    $coursegraph->timecreated = time();
    $coursegraph->timemodified = time();

    return $DB->insert_record('coursegraph', $coursegraph);
}

function coursegraph_update_instance($coursegraph)
{
    global $DB;

    $coursegraph->timemodified = time();
    $coursegraph->id = $coursegraph->instance;

    return $DB->update_record('coursegraph', $coursegraph);
}

function coursegraph_delete_instance($id)
{
    global $DB;

    if (!$coursegraph = $DB->get_record('coursegraph', array('id' => $id))) {
        return false;
    }

    $DB->delete_records('coursegraph', array('id' => $coursegraph->id));

    return true;
}
