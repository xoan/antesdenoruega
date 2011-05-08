<?php
class User extends fActiveRecord
{
	protected function configure()
	{
		fORMValidation::addRequiredRule($this, array('name', 'password', 'email'));
		fORMValidation::addRegexRule($this, 'name', '/^([a-z0-9_])+$/i', 'The value entered has invalid characters, only alphanumeric and _ are allowed');
		fORMColumn::configureEmailColumn($this, 'email');
		fORM::registerHookCallback($this, 'post-validate::store()', 'User::hashPassword');
	}
	
	static public function hashPassword($object, &$values, &$old_values, &$related_records, &$cache)
	{
		$values['password'] = fCryptography::hashPassword(fRequest::get('password'));
	}
}
