<?php

/**
 * Class CRM_KavaQuickSearch_APIWrapper.
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
class CRM_KavaQuickSearch_APIWrapper implements API_Wrapper {

  public function fromApiInput($apiRequest) {

    if ($apiRequest['entity'] != 'Contact' || $apiRequest['action'] != 'getquick' || !is_array($apiRequest['params']) || empty($apiRequest['params']['name'])) {
      return $apiRequest;
    }

    if (in_array($apiRequest['params']['field_name'], ['kava_custom_apb', 'kava_custom_barcode'])) {
      $cf = CRM_KavaGeneric_CustomField::singleton();
      switch ($apiRequest['params']['field_name']) {
        case 'kava_custom_apb':
          $apiRequest['params']['field_name'] = $cf->getApiFieldName('contact_apotheekuitbating', 'APB_nummer');
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

    $res = civicrm_api3('Contact', 'get', [
      $params['field_name'] => $params['name'],
      'is_deleted'          => FALSE,
      'sequential'          => TRUE,
      'return'              => ['id', 'sort_name', $params['field_name']],
    ]);

    foreach ($res['values'] as $idx => $value) {
      $res['values'][$idx]['data'] = $value['sort_name'] . " ({$value[$params['field_name']]})";
    }

    return $res;
  }

  public function toApiOutput($apiRequest, $result) {

    return $result;
  }
}
