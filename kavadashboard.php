<?php

require_once 'kavadashboard.civix.php';

/**
 * Implements hook_civicrm_coreResourceList.
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_coreResourceList
 *
 * Add custom JS to add extra fields to the quick search box.
 */
function kavadashboard_civicrm_coreResourceList(&$list, $region) {
  $res = CRM_Core_Resources::singleton();
  $res->addScriptFile('be.kava.dashboard', 'js/quicksearch_extend.js', 1001, 'html-header', FALSE);
}

/**
 * Implements hook_civicrm_apiWrappers().
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_apiWrappers
 *
 * Add an API wrapper to handle quick searches for custom fields.
 * @param array $wrappers
 * @param array $apiRequest
 */
function kavadashboard_civicrm_apiWrappers(&$wrappers, $apiRequest) {
  if($apiRequest['entity'] == 'Contact' && $apiRequest['action'] == 'getquick') {
    $wrappers[] = new CRM_KavaDashboard_API_Wrapper;
  }
}

/* function kavadashboard_civicrm_dashboard($contactID, &$contentPlacement) {
  // REPLACE Activity Listing with custom content
  $contentPlacement = 3;
  $content = array(
    'Custom Content' => "Here is some custom content: $contactID",
    'Custom Table' => "
      <table>
      <tr><th>Contact Name</th><th>Date</th></tr>
      <tr><td>Foo</td><td>Bar</td></tr>
      <tr><td>Goo</td><td>Tar</td></tr>
      </table>",
  );
  return $content;
} */


/** Default Civix hooks follow **/

function kavadashboard_civicrm_enable() {
  _kavadashboard_civix_civicrm_enable();
}

function kavadashboard_civicrm_install() {
    _kavadashboard_civix_civicrm_install();
}

function kavadashboard_civicrm_uninstall() {
    _kavadashboard_civix_civicrm_uninstall();
}

function kavadashboard_civicrm_config(&$config) {
  _kavadashboard_civix_civicrm_config($config);
}

function kavadashboard_civicrm_xmlMenu(&$files) {
    _kavadashboard_civix_civicrm_xmlMenu($files);
}

function kavadashboard_civicrm_disable() {
    return _kavadashboard_civix_civicrm_disable();
}

function kavadashboard_civicrm_upgrade($op, CRM_Queue_Queue $queue = null) {
    return _kavadashboard_civix_civicrm_upgrade($op, $queue);
}

function kavadashboard_civicrm_managed(&$entities) {
    _kavadashboard_civix_civicrm_managed($entities);
}

function kavadashboard_civicrm_caseTypes(&$caseTypes) {
    _kavadashboard_civix_civicrm_caseTypes($caseTypes);
}

function kavadashboard_civicrm_alterSettingsFolders(&$metaDataFolders = null) {
    _kavadashboard_civix_civicrm_alterSettingsFolders($metaDataFolders);
}
