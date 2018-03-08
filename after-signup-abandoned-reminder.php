<?php
$str_post = array(
    "properties" => array(
        array(
             "property" => "tps_registration_abandoned",
             "value"    => "Yes"
        )
    )
);
$member_email = $this->get_email(); 
$this->update_contact_by_email($member_email, $str_post);