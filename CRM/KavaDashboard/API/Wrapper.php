<?php

/**
 * Class CRM_KavaDashboard_API_Wrapper.
 * API wrapper to handle quick searches for custom fields.
 *
 * For information about how this hook works, see
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_apiWrappers
 * Functionality inspired by this thread on StackOverflow:
 * @link https://civicrm.stackexchange.com/questions/4011/is-there-a-recommended-way-to-customise-the-quicksearch
 *
 * @author Kevin Levie <kevin.levie@civicoop.org>
 * @package be.kava.quicksearch
 * @license AGPL-3.0
 */
class CRM_KavaDashboard_API_Wrapper implements API_Wrapper {

  public function fromApiInput($apiRequest) {

    if ($apiRequest['entity'] != 'Contact' || $apiRequest['action'] != 'getquick' || !is_array($apiRequest['params']) || empty($apiRequest['params']['name'])) {
      return $apiRequest;
    }

    if (in_array($apiRequest['params']['field_name'], ['kava_custom_apb', 'kava_custom_barcode'])) {
      $cf = CRM_KavaGeneric_CustomField::singleton();
      switch ($apiRequest['params']['field_name']) {
        case 'kava_custom_apb':
          $apbNrFieldName = $cf->getApiFieldName('contact_apotheekuitbating', 'APB_nummer');
          $overnameFieldName = $cf->getApiFieldName('contact_apotheekuitbating', 'Overname');

          $apiRequest['params']['field_name'] = $apbNrFieldName;
          $apiRequest['params']['extra_field_name'] = $overnameFieldName;
          $apiRequest['params']['sort'] = $overnameFieldName . ' DESC';
          break;
        case 'kava_custom_barcode':
          $apiRequest['params']['field_name'] = $cf->getApiFieldName('contact_extra', 'Barcode');
          break;
      }

      $apiRequest['action'] = 'getlist';
      $apiRequest['function'] = [$this, 'getCustomContactList'];
    }

    return $apiRequest;
  }

  public function getCustomContactList($params) {

    $returnFields = ['id', 'sort_name', $params['field_name']];
    $options = [];
    if (isset($params['extra_field_name'])) {
      $returnFields[] = $params['extra_field_name'];
    }
    if (isset($params['sort'])) {
      $options['sort'] = $params['sort'];
    }

    $res = civicrm_api3('Contact', 'get', [
      $params['field_name'] => $params['name'],
      'is_deleted'          => FALSE,
      'sequential'          => TRUE,
      'return'              => $returnFields,
      'options'             => $options,
    ]);

    foreach ($res['values'] as $idx => $value) {
      $displayName = $value['sort_name'] . " (" . $value[$params['field_name']];
      if (isset($params['extra_field_name']) && isset($value[$params['extra_field_name']])) {
        $displayName .= "." . $value[$params['extra_field_name']];
      }
      $displayName .= ")";

      $res['values'][$idx]['data'] = $displayName;
    }

    return $res;
  }

  public function toApiOutput($apiRequest, $result) {

    return $result;
  }
}
