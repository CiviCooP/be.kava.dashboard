<?php

require_once 'kavaquicksearch.civix.php';

/**
 * Implements hook_civicrm_coreResourceList.
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_coreResourceList
 *
 * Add custom JS to add extra fields to the quick search box.
 */
function kavaquicksearch_civicrm_coreResourceList(&$list, $region) {
  $res = CRM_Core_Resources::singleton();
  $res->addScriptFile('be.kava.quicksearch', 'js/qsextend.js', 1001, 'html-header', FALSE);
}

/**
 * Implements hook_civicrm_apiWrappers().
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_apiWrappers
 *
 * Add an API wrapper to handle quick searches for custom fields.
 * @param array $wrappers
 * @param array $apiRequest
 */
function kavaquicksearch_civicrm_apiWrappers(&$wrappers, $apiRequest) {
  if($apiRequest['entity'] == 'Contact' && $apiRequest['action'] == 'getquick') {
    $wrappers[] = new CRM_KavaQuickSearch_APIWrapper;
  }
}


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
