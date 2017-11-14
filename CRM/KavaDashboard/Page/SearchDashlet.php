<?php

require_once 'CRM/Core/Page.php';

class CRM_KavaDashboard_Page_SearchDashlet extends CRM_Core_Page {

  function run() {

    $res = CRM_Core_Resources::singleton();
    $res->addScriptFile('be.kava.dashboard', 'js/dashlet_search.js', 1012);
    $res->addStyleFile('be.kava.dashboard', 'assets/dashlet_search.css', 1012);

    CRM_Utils_System::setTitle(ts('KAVA Search Dashlet'));
    parent::run();
  }
}