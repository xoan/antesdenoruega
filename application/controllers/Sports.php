<?php
class Sports extends MoorActionController
{
	private $data = array();
	
	protected function afterAction()
	{
		render($this->data);
	}
	
	public function index()
	{
		//
	}
	
	public function show()
	{
		//
	}
}
