<?php
class Users extends MoorActionController
{
	private $data = array();
	
	protected function afterAction()
	{
		render($this->data);
	}
	
	public function create()
	{
		$user = new User();
		$blocks = fRecordSet::build('Block', null, array('name' => 'asc'));
		if (fRequest::isPost()) {
			try {
				$user->populate();
				$user->store();
				fURL::redirect(link_to('Sessions::create'));
			} catch (fExpectedException $e) {
				fMessaging::create('error', link_to('Users::create'), $e->getMessage());
			}
		}
		$this->data['user'] = $user;
		$this->data['blocks'] = $blocks;
	}
	
	public function edit()
	{
		$user = new User(array('name' =>fAuthorization::getUserToken()));
		$blocks = fRecordSet::build('Block', null, array('name' => 'asc'));
		if (fRequest::isPost()) {
			try {
				if (strlen(fRequest::get('password')) > 0) {
					$user->setPassword(fRequest::get('password'));
				}
				$user->setEmail(fRequest::get('email'));
				$user->setBlockId(fRequest::get('block_id'));
				$user->store();
			} catch (fExpectedException $e) {
				fMessaging::create('error', link_to('Users::edit'), $e->getMessage());
			}
		}
		$this->data['user'] = $user;
		$this->data['blocks'] = $blocks;
	}
}
