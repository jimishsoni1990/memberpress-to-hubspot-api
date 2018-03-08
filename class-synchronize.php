<?php
class Synchronize{

	private $data;

	private $APIKey = 'xxxxxxxxxxxx';
	private $formId = 'xxxxxxxxxxxx';
	private $hubId 	= 'xxxxxxxxxxxx';

	private function debug($debug_data)
	{
		$log_time = date('Y-m-d h:i:sa');
		$this->wh_log("************** Start Log For Day : '" . $log_time . "'**********");
		$this->wh_log($debug_data);
		$this->wh_log("************** END Log For Day : '" . $log_time . "'**********");
		 
	}

	private function wh_log($debug_data)
	{
	    $log_filename = "Synchronize_log";
	    if (!file_exists($log_filename)) 
	    {
	        // create directory/folder uploads.
	        mkdir($log_filename, 0777, true);
	    }
	    $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
	    file_put_contents($log_file_data, print_r($debug_data, TRUE) . "\n", FILE_APPEND);
	}

	private function get_ip_address(){
		return $this->data->ip;
	}

	private function get_firstname(){
		return $this->data->first_name;
	}

	private function get_lastname(){
		return $this->data->last_name;
	}

	private function get_member_id(){
		return $this->data->member->id;
	}

	private function get_email(){

		if($this->data->email){
			return $this->data->email;
		} elseif ($this->data->member->email) {
			return $this->data->member->email;
		} else {
			exit("No email address found.");
		}
	}

	private function get_address_line_1(){
		$address_1 = 'mepr-address-one';
		if($this->data->address->{$address_1}){
			return $this->data->address->{$address_1};	
		} elseif ($this->data->member->address->{$address_1}){
			return $this->data->member->address->{$address_1};
		} else { return ''; }
		
	}

	private function get_address_line_2(){
		$address_2 = 'mepr-address-two';
		if($this->data->address->{$address_2}){
			return $this->data->address->{$address_2};	
		} elseif ($this->data->member->address->{$address_2}){
			return $this->data->member->address->{$address_2};
		} else { return ''; }
	}

	private function get_city(){
		$city = 'mepr-address-city';
		if($this->data->address->{$city}){
			return $this->data->address->{$city};	
		} elseif ($this->data->member->address->{$city}){
			return $this->data->member->address->{$city};
		} else { return ''; }
	}

	private function get_state(){
		$state = 'mepr-address-state';
		if($this->data->address->{$state}){
			return $this->data->address->{$state};	
		} elseif ($this->data->member->address->{$state}){
			return $this->data->member->address->{$state};
		} else { return ''; }
	}

	private function get_country(){
		$country = 'mepr-address-country';
		if($this->data->address->{$country}){
			return $this->data->address->{$country};	
		} elseif ($this->data->member->address->{$country}){
			return $this->data->member->address->{$country};
		} else { return ''; }
	}

	private function get_zip(){
		$zip = 'mepr-address-zip';
		if($this->data->address->{$zip}){
			return $this->data->address->{$zip};	
		} elseif ($this->data->member->address->{$zip}){
			return $this->data->member->address->{$zip};
		} else { return ''; }
	}

	private function get_event_name(){
		return $this->data->event;
	}

	private function get_registeration_date_time()
	{
		$dateString = $this->data->registered_at;
		if( strtotime( $dateString) > 0 ){
			return (date_create($dateString)->setTimezone(timezone_open('UTC'))->modify('midnight')->getTimestamp())*1000;
		} else { return ''; }
	}

	private function get_expiration_date()
	{
		if( isset($this->data->recent_transactions[0]->status) && $this->data->recent_transactions[0]->status == 'complete' ){
			$dateString = $this->data->recent_transactions[0]->expires_at;
			if( strtotime( $dateString) > 0 ){
  				return (date_create($dateString)->setTimezone(timezone_open('UTC'))->modify('midnight')->getTimestamp())*1000;
  			} else { return ''; }
		} elseif($this->data->expires_at){
			$dateString = $this->data->expires_at;
			if( strtotime( $dateString) > 0 ){
  				return (date_create($dateString)->setTimezone(timezone_open('UTC'))->modify('midnight')->getTimestamp())*1000;
  			} else { return ''; }
		}
		return ''; 
	}

	private function get_first_payment_date()
	{
		if( $this->data->recent_transactions[0]->status == 'complete' ){
			$dateString = $this->data->recent_transactions[0]->created_at;
			if( strtotime( $dateString) > 0 ){
  				return (date_create($dateString)->setTimezone(timezone_open('UTC'))->modify('midnight')->getTimestamp())*1000;
  			} else { return ''; }
		} 
		return '';
	}

	private function get_transaction_date()
	{
		$dateString = $this->data->created_at;
		return (date_create($dateString)->setTimezone(timezone_open('UTC'))->modify('midnight')->getTimestamp())*1000;
	}

	private function get_subscription_package_title()
	{
		if($this->data->active_memberships[0]->title){
			return $this->data->active_memberships[0]->title;
		} elseif($this->data->membership->title){
			return $this->data->membership->title;
		} else { return ''; }
	}

	private function get_subscription_price()
	{
		if($this->data->active_memberships[0]->price){
			return $this->data->active_memberships[0]->price;
		} elseif($this->data->total){
			return $this->data->total;
		} else { return ''; }
	}

	private function get_username()
	{
		return $this->data->username;
	}

	private function get_profile_username()
	{
		if($this->data->profile->mepr_username != ''){
			return $this->data->profile->mepr_username;
		}	else {
			return $this->get_username();
		}
	}

	private function get_phone()
	{
		return $this->data->profile->mepr_phone;
	}
	
	private function get_subscription_type()
	{
		if( $this->data->active_memberships[0]->title  == "Complimentary" ){
			return 'Complimentary Subscription';
		} elseif( $this->data->membership->title == "Complimentary" ){
			return 'Complimentary Subscription';
		} else {
			return 'Paid Subscription';		     	
		}
		
	}

	private function get_cancel_subscription_type()
	{
		return 'Inactive Subscription';
	}

	private function get_pipeline()
	{
		return 'default';
	}

	private function get_dealstage()
	{
		return 'closedwon';
	}

	private function get_coupon_used()
	{
		if($this->data->coupon->coupon_code){
			return $this->data->coupon->coupon_code;
		} else { return ''; }
	}

	private function get_subscription_cancle_date()
	{
		$dateString = date('Y-m-d');
		if( strtotime( $dateString) > 0 ){
			return (date_create($dateString)->setTimezone(timezone_open('UTC'))->modify('midnight')->getTimestamp())*1000;
		} else { return ''; }

	}

	private function get_subscription_expired_status()
	{
		return 'Expired';
	}

	
	private function get_contact_id($member_email) 
	{
		$endpoint = "https://api.hubapi.com/contacts/v1/contact/email/$member_email/profile?hapikey=".$this->APIKey;
		$response = $this->get_curl_response($endpoint);

		if($response['status_code'] == 200){
			$contact_data = json_decode($response['response']);
			return $contact_data->vid;
		} else {
			exit("Can't find contact: $member_email");
		}
	}

	private function get_curl_response($endpoint)
	{
		$output = '';
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $endpoint,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		   'Content-Type: application/x-www-form-urlencoded'
		  ),
		));

		$output['response'] 	 	= curl_exec($curl);
		$output['error']		 	= curl_error($curl);
		$output['status_code'] 		= curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		return $output;
	}

	private function email_exist( $member_email )
	{
		$endpoint = "https://api.hubapi.com/contacts/v1/contact/email/$member_email/profile?hapikey=".$this->APIKey;

		$response = $this->get_curl_response($endpoint);

		if($response['status_code'] != 404){
			return true;
		} else {
			return false;
		}

	}

	private function create_contact($data)
	{
		$endpoint = "https://forms.hubspot.com/uploads/form/v2/".$this->hubId."/".$this->formId;
		$this->post_data($data, $endpoint);
	}

	private function update_contact_by_email($member_email, $data)
	{
		$data = json_encode($data);
		$endpoint = "https://api.hubapi.com/contacts/v1/contact/email/$member_email/profile?hapikey=".$this->APIKey;
		sleep(10); // Hubspot api take some time to make the record available for query
		$this->post_data($data, $endpoint);
	}

	private function create_deal($member_email, $data)
	{
		$contact_id  = $this->get_contact_id($member_email);
		$data['associations']['associatedVids'] = array($contact_id);
		$data = json_encode($data);

		
		$endpoint = "https://api.hubapi.com/deals/v1/deal?hapikey=".$this->APIKey;
		$this->post_data($data, $endpoint, 'json');
	}

	private function post_data($data, $endpoint, $encoding_type = 'x-www-form-urlencoded')
	{
		$ch = @curl_init();
		@curl_setopt($ch, CURLOPT_POST, true);
		@curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		@curl_setopt($ch, CURLOPT_URL, $endpoint);
		@curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    "Content-Type: application/$encoding_type"
		));
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response    = @curl_exec($ch); 
		$error		 = @curl_error($ch);
		$status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		@curl_close($ch);
		$result = $response . ' - ' .$status_code. ' - '. $error; 
		$this->debug($data.$endpoint.$result);
	}


	private function get_txn_type()
	{
		if($this->data->txn_type){
			return $this->data->txn_type;
		} else { return ''; }
	}

	public function perform_sync($eventobj)
	{
		
		$event_name = $eventobj->event;
		$this->data = $eventobj->data;
		$this->debug($event_name);
		$filename = '';
		switch ($event_name) {
			
			// Sent when a new member registers but before their payment details are accepted.
			case 'member-added': 
					$filename = 'new_member_register_without_payment.php';
				break;

			//Sent when a new member completes the signup and their payment is accepted.
			case 'member-signup-completed': 
					$filename = 'new_member_register_with_payment.php';
				break;

			//Sent when a member updates his/her account information.
			case 'member-account-updated': 
					$filename = 'member-account-updated.php';
				break;

			//Sent when a subscription is cancelled.
			case 'subscription-stopped': 
					$filename = 'subscription-stopped.php';
				break;

			//Sent when a subscription expires.
			case 'subscription-expired': 
					$filename = 'subscription-expired.php';
				break;

			//Sent when a transaction has completed on MemberPress.
			case 'transaction-completed': 
					$filename = 'transaction-completed.php';
				break;

			//Sent when any transaction is refunded.
			case 'transaction-refunded': 
					$filename = 'transaction-refunded.php';
				break;

			//Sent when a transaction associated with a subscription completes.
			case 'recurring-transaction-completed': 
					$filename = 'recurring-transaction-completed.php';
				break;

			//Sent when any transaction associated with a subscription expires. This event will not indicate that a recurring subscription is expiring.
			case 'recurring-transaction-expired': 
					$filename = 'recurring-transaction-expired.php';
				break;

			//Sent when any transaction not associated with a subscription expires.
			case 'non-recurring-transaction-expired': 
					$filename = 'non-recurring-transaction-expired.php';
				break;

			//Sent when any After Member Signup Abandoned reminder fires.
			case 'after-signup-abandoned-reminder': 
					$filename = 'after-signup-abandoned-reminder.php';
				break;

			//Sent when a subscription is created.
			case 'subscription-created': 
					$filename = 'subscription-created.php';
				break;

			//Sent when a subscription is upgraded.
			case 'subscription-upgraded': 
					$filename = 'subscription-upgraded.php';
				break;
			
			//Sent when a subscription is downgraded.
			case 'subscription-downgraded': 
					$filename = 'subscription-downgraded.php';
				break;

			default:
				
				break;

		}

		if( $filename != '' ){
			require_once(dirname(__FILE__) . "/sync-operations/$filename");
		}

	}
}