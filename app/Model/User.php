<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Group $Group
 * @property Article $Article
 */
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'first_name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'first_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),

			),
		),
		'last_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),

			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),

			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This email has already been taken.'			
			)
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),

			),
			'strong' => array(
				'rule' => array('strong'),
				'message' => 'Password is not strong.',
			)
		),
        'confirm_password' => array(
            'equalToField' => array(
				'rule' => array('equalToField','password'),
				'message' => 'Password did not match.',
            )
        ),		
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),

			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',

		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'user_id',
			'dependent' => true,
		)
	);

	public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false));


	public function strong($check) {
        //get name of field
        $fname = '';
        foreach ($check as $key => $value){
            $fname = $key;
            break;
        }
        return preg_match('/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',$this->data[$this->name][$fname]);
    } 
	

	public function equalToField($check,$otherfield) {
        //get name of field
        $fname = '';
        foreach ($check as $key => $value){
            $fname = $key;
            break;
        }
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname];
    } 
	
    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        }
        return array('Group' => array('id' => $groupId));
    }
	
	public function bindNode($user) {
		return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
	}	
	
    public function beforeSave($options = array()) {
        if(isset($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password(
			  $this->data['User']['password']
			);
		}
        return true;
    }	
}
