<?php

require_once 'CRM/Core/Page.php';

class CRM_KavaDashboard_Page_LinksDashlet extends CRM_Core_Page {

  function run() {

    try {
      $customSearchId = civicrm_api3('CustomSearch', 'getvalue', [
        'name'   => 'CRM_Search_Form_Search_Contactgegevens',
        'return' => 'value',
      ]);
    } catch(CiviCRM_API3_Exception $e) {
      $customSearchId = null;
    }

    $this->assign('kavaCustomSearchUrl', CRM_Utils_System::url("civicrm/contact/search/custom",
      'reset=1&csid=' . $customSearchId));

    CRM_Utils_System::setTitle(ts('KAVA Links Dashlet'));
    parent::run();
  }
}
