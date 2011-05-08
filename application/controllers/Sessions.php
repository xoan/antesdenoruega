<?php
class Sessions extends MoorActionController
{
	private $data = array();
	
	protected function afterAction()
	{
		render($this->data);
	}
	
	public function create()
	{
		if (fRequest::isPost()) {
			try {
				$validation = new fValidation();
				$validation->addRequiredFields('name', 'password');
				$validation->validate();
				$user = new User(array('name' => fRequest::get('name')));
				if (!fCryptography::checkPasswordHash(fRequest::get('password'), $user->getPassword())) {
					throw new fValidationException('Incorrect password');
				}
				fAuthorization::setUserToken($user->getName());
				fURL::redirect(link_to('Welcome::index'));
			} catch (fExpectedException $e) {
				fMessaging::create('error', link_to('Sessions::create'), $e->getMessage());
			}
		}
	}
	
	public function destroy()
	{
		fAuthorization::destroyUserInfo();
		fURL::redirect(link_to('Welcome::index'));
	}
}
