<?php

require_once 'kavaquicksearch.civix.php';


/** Default Civix hooks follow **/

function kavaquicksearch_civicrm_enable() {
  _kavaquicksearch_civix_civicrm_enable();
}

function kavaquicksearch_civicrm_install() {
    _kavaquicksearch_civix_civicrm_install();
}

function kavaquicksearch_civicrm_uninstall() {
    _kavaquicksearch_civix_civicrm_uninstall();
}

function kavaquicksearch_civicrm_config(&$config) {
    _kavaquicksearch_civix_civicrm_config($config);
}

function kavaquicksearch_civicrm_xmlMenu(&$files) {
    _kavaquicksearch_civix_civicrm_xmlMenu($files);
}

function kavaquicksearch_civicrm_disable() {
    return _kavaquicksearch_civix_civicrm_disable();
}

function kavaquicksearch_civicrm_upgrade($op, CRM_Queue_Queue $queue = null) {
    return _kavaquicksearch_civix_civicrm_upgrade($op, $queue);
}

function kavaquicksearch_civicrm_managed(&$entities) {
    _kavaquicksearch_civix_civicrm_managed($entities);
}

function kavaquicksearch_civicrm_caseTypes(&$caseTypes) {
    _kavaquicksearch_civix_civicrm_caseTypes($caseTypes);
}

function kavaquicksearch_civicrm_alterSettingsFolders(&$metaDataFolders = null) {
    _kavaquicksearch_civix_civicrm_alterSettingsFolders($metaDataFolders);
}
