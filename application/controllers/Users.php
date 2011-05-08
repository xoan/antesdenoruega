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
		//
	}
}
