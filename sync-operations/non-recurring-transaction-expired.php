<?php
if( $this->get_txn_type() != "subscription_confirmation" ){ 
    $str_post = array(
        "properties" => array(
            array(
                    "property" => "tps_subscription_type",
                    "value"    => $this->get_cancel_subscription_type()
                ),
            array(
                    "property" => "tps_recurring_transaction",
                    "value"    => $this->get_subscription_expired_status()
                )
        )
    );

    $member_email = $this->get_email(); 

    $this->update_contact_by_email($member_email, $str_post);
}