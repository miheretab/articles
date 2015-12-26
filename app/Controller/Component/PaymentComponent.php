<?php
App::uses('Component', 'Controller');

class PaymentComponent extends Component {
    
	public function charge($cc, $cvc, $expDate, $firstName, $lastName, $amount) {
        if(isset($cc) && isset($cvc) && isset($expDate) && isset($firstName) && isset($lastName) && isset($amount)) {
			return true;
		}
		
		return false;
    }
}