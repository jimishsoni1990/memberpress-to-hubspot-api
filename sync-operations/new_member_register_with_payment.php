<?php
if( !$this->email_exist( $this->get_email() ) ){

$hs_context     = array(
    'ipAddress' => $this->get_ip_address(),
);

$hs_context_json = json_encode($hs_context);
$member_email = $this->get_email();

    $str_post = "firstname=" . urlencode($this->get_firstname());

    if( $this->get_lastname() != '' ){
        $str_post .= "&lastname=" . urlencode($this->get_lastname());
    }
    if( $member_email != '' ){
        $str_post .= "&email=" . urlencode($member_email);
    }
    if( $this->get_address_line_1() != '' ){
        $str_post .= "&address=" . urlencode($this->get_address_line_1());
    }
    if( $this->get_address_line_2() != '' ){
        $str_post .= "&adress_line_2=" . urlencode($this->get_address_line_2());
    }
    if( $this->get_city() != '' ){
        $str_post .= "&city=" . urlencode($this->get_city());
    }
    if( $this->get_country() != '' ){
        $str_post .= "&country=" . urlencode($this->get_country());
    }
    if( $this->get_state() != '' ){
        $str_post .= "&state=" . urlencode($this->get_state());
    }
    if( $this->get_zip() != '' ){
        $str_post .= "&zip=" . urlencode($this->get_zip());
    }
    if( $hs_context_json != '' ){
        "&hs_context=" . urlencode($hs_context_json);
    }

    $this->create_contact($str_post);

}

// Get the new contact details by email and update data for the contact
$update_data['properties'] = array();

    if( $this->get_expiration_date() != '' ){
        $update_data['properties'][] = array(
                                                "property" => "tps_expiration_date",
                                                "value"    => $this->get_expiration_date()
                                            );
    }

    if( $this->get_first_payment_date() != '' ){
        $update_data['properties'][] = array(
                                                "property" => "first_tps_payment_date",
                                                "value"    => $this->get_first_payment_date()
                                            );
    }

    if( $this->get_registeration_date_time() != '' ){
        $update_data['properties'][] =  array(
                                                "property" => "tps_registration_date",
                                                "value"    => $this->get_registeration_date_time()
                                            );
    }

    if( $this->get_subscription_package_title() != '' ){
        $update_data['properties'][] =  array(
                                                "property" => "tps_subscription_package",
                                                "value"    => $this->get_subscription_package_title()
                                            );
    }

    if( $this->get_subscription_type() != '' ){
        $update_data['properties'][] =  array(
                                                "property" => "tps_subscription_type",
                                                "value"    => $this->get_subscription_type()
                                            );
    }

    if( $this->get_firstname() != '' ){
        $update_data['properties'][] = array(
                                            "property" => "firstname",
                                            "value"    => $this->get_firstname()
                                        );
    }

    if( $this->get_lastname() != '' ){
        $update_data['properties'][] = array(
                                            "property" => "lastname",
                                            "value"    => $this->get_lastname()
                                        );
    }

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

    if( $this->get_phone() != '' ){
        $update_data['properties'][] = array(
                                            "property" => "phone",
                                            "value"    => $this->get_phone()
                                        );
    }

    if( $this->get_profile_username() != '' ){
        $update_data['properties'][] = array(
                                            "property" => "tps_username",
                                            "value"    => $this->get_profile_username()
                                        );
    }

    $this->update_contact_by_email($this->get_email(), $update_data);
