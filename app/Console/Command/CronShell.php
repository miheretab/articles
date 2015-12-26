<?php

class CronShell extends AppShell {
	
/**
 * reduce balance shell
 *
 * @return void
 * this cron should run once in a day
 * (0  0    *    *    *  cd /full/path/to/app && Console/cake cron)
 */ 	
    public function main() {
		$this->loadModel('User');
		$users = $this->User->find('all', array('conditions' => array('group_id' => 2)));					
		foreach($users as $user) {
			if($user['User']['balance'] > 0) {
				$newBalance = $user['User']['balance'] - 1;
			} else {
				$newBalance = 0;
			}
			$this->User->id = $user['User']['id'];
			$this->User->saveField('balance', $newBalance, false);
		}		
		
		$this->out('Done.');
    }
	
}
