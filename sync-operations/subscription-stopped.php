<?php
$str_post = array(
    "properties" => array(
        array(
                "property" => "tps_subscription_type",
                "value"    => $this->get_cancel_subscription_type()
            ),
        array(
                "property" => "tps_cancellation_date",
                "value"    => $this->get_subscription_cancle_date()
            )
    )
);

$member_email = $this->get_email(); 

$this->update_contact_by_email($member_email, $str_post);
