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

    if($apiRequest['entity'] != 'Contact' || $apiRequest['action'] != 'getquick' || !is_array($apiRequest['params'])) {
      return $apiRequest;
    }

    // TODO HANDLE ACTUAL SEARCH

    // require_once __DIR__ . '/../../../be.kava.generic/CRM/KavaGeneric/CustomField.php';
    // $cf = CRM_KavaGeneric_CustomField::singleton();
    // if($apiRequest['params']['field_name'] == 'kava_custom_apb') // || kava_custom_barcode
    // $cf->getApiFieldName('contact_apotheekuitbating', 'APB_nummer')
    // $cf->getApiFieldName('contact_extra', 'Barcode')
    // ... see link for example

    return $apiRequest;
  }

  public function toApiOutput($apiRequest, $result) {

    return $result;
  }
}
