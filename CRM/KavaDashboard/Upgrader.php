<?php

/**
 * Class CRM_KavaDashboard_Upgrader.
 * Collection of upgrade steps.
 */
class CRM_KavaDashboard_Upgrader extends CRM_KavaDashboard_Upgrader_Base {

  protected static $dashlets = [
    'kava_search' => 'Snelzoeken',
  ];

  /**
   * Add our dashlets to civicrm_dashboard table.
   * @return bool Success
   */
  public function onEnable() {

    $existing_dashlets = $this->getDashlets();

    foreach (static::$dashlets as $dashlet_key => $dashlet_label) {
      if (!in_array($dashlet_key, $existing_dashlets)) {
        civicrm_api3('Dashboard', 'create', [
          'name'           => $dashlet_key,
          'label'          => $dashlet_label,
          'url'            => 'civicrm/dashlet/' . $dashlet_key . '?reset=1&snippet=5',
          'fullscreen_url' => 'civicrm/dashlet/' . $dashlet_key . '?reset=1&snippet=5&context=dashletFullscreen',
          'permission'     => 'access CiviCRM',
          'is_fullscreen'  => 0,
          'is_active'      => 1,
          'weight'         => 101,
        ]);
      }
    }

    return TRUE;
  }

  /**
   * Remove our dashlets from civicrm_dashboard table.
   * @return bool Success
   */
  public function onDisable() {

    $existing_dashlets = $this->getDashlets();

    foreach (static::$dashlets as $dashlet_key => $dashlet_label) {
      if (in_array($dashlet_key, $existing_dashlets)) {
        $id = array_search($dashlet_key, $existing_dashlets);
        civicrm_api3('Dashboard', 'delete', ['id' => $id]);
      }
    }

    return TRUE;
  }

  /**
   * Function to fetch dashlets (used in the install/uninstall scripts above).
   * @return array Dashlets
   * @throws \Exception When dashlets could not be initialised
   */
  private function getDashlets() {

    $data = civicrm_api3('Dashboard', 'get');
    if ($data['is_error']) {
      throw new Exception("Could not initialise dashlets. API error: " . $data['error_message']);
    }

    $dashlet_data = [];
    foreach ($data['values'] as $dashlet) {
      $dashlet_data[$dashlet['id']] = $dashlet['name'];
    }
    return $dashlet_data;
  }
}
