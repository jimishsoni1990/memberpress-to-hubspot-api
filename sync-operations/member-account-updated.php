<?php

$update_data['properties'] = array();

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


    $member_email = $this->get_email(); 
    $this->update_contact_by_email($member_email, $update_data);