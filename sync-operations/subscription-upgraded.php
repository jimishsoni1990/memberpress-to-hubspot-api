<?php
  $update_data['properties'] = array();

  if( $this->get_address_line_1() != '' ){
      $update_data['properties'][] = array(
                                          "property" => "address",
                                          "value"    => $this->get_address_line_1()
                                      );
  }

  if( $this->get_address_line_2() != '' ){
      $update_data['properties'][] = array(
                                          "property" => "adress_line_2",
                                          "value"    => $this->get_address_line_2()
                                      );
  }

  if( $this->get_city() != '' ){
      $update_data['properties'][] = array(
                                          "property" => "city",
                                          "value"    => $this->get_city()
                                      );
  }

  if( $this->get_country() != '' ){
      $update_data['properties'][] = array(
                                          "property" => "country",
                                          "value"    => $this->get_country()
                                      );
  }

  if( $this->get_state() != '' ){
      $update_data['properties'][] = array(
                                          "property" => "state",
                                          "value"    => $this->get_state()
                                      );
  }

  if( $this->get_zip() != '' ){
      $update_data['properties'][] = array(
                                          "property" => "zip",
                                          "value"    => $this->get_zip()
                                      );
  }

  if( $this->get_expiration_date() != '' ){
      $update_data['properties'][] = array(
                                          "property" => "tps_expiration_date",
                                          "value"    => $this->get_expiration_date()
                                      );
  }

  if( $this->get_subscription_package_title() != '' ){
      $update_data['properties'][] = array(
                                          "property" => "tps_subscription_package",
                                          "value"    => $this->get_subscription_package_title()
                                      );
  }

  if( $this->get_subscription_type() != '' ){
      $update_data['properties'][] = array(
                                          "property" => "tps_subscription_type",
                                          "value"    => $this->get_subscription_type()
                                      );
  }

  // $update_data['properties'][]    =  array(
  //                                         "property" => "tps_recurring_transaction",
  //                                         "value"    => 'No' // this is only updated when event is recurring transaction completed.
  //                                     );

  $member_email = $this->get_email(); 
  $this->update_contact_by_email($member_email, $update_data);

  // update deal
  $deal_data['associations'] = array();
  $deal_data['associations']['associatedVids'] = array();
  $deal_data['properties'] = array();

  if( $this->get_subscription_package_title() != '' ){
      $deal_data['properties'][] = array(
                                          "name" => "dealname",
                                          "value"    => $this->get_subscription_package_title()
                                          );
  }

  if( $this->get_pipeline() != '' ){
      $deal_data['properties'][] = array(
                                          "name" => "pipeline",
                                          "value"    => $this->get_pipeline()
                                          );
  }

  if( $this->get_subscription_price() != '' ){
    $deal_data['properties'][] = array(
                                        "name" => "amount",
                                        "value"    => $this->get_subscription_price()
                                        );
  }

  if( $this->get_transaction_date() != '' ){
    $deal_data['properties'][] = array(
                                        "name" => "closedate",
                                        "value"    => $this->get_transaction_date()
                                        );
  }

  if( $this->get_dealstage() != '' ){
    $deal_data['properties'][] = array(
                                        "name" => "dealstage",
                                        "value"    => $this->get_dealstage()
                                        );
  }

  if( $this->get_coupon_used() != '' ){
    $deal_data['properties'][] = array(
                                        "name" => "coupon_code",
                                        "value"    => $this->get_coupon_used()
                                        );
  }

  $this->create_deal($this->get_email(), $deal_data);