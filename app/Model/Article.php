<?php
App::uses('AppModel', 'Model');
/**
 * Article Model
 *
 * @property User $User
 */
class Article extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),

			),
		),
		'content' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),

			),
		),
		'enabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),

			),
		),
		'user_id' => array(
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',

		)
	);
}
