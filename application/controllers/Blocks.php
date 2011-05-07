<?php
class Blocks extends MoorActionController
{
	private $data = array();
	
	protected function afterAction()
	{
		render($this->data);
	}
	
	public function index()
	{
		$blocks = fRecordSet::build('Block');
		$this->data['blocks'] = $blocks;
		
	}
	
	public function show()
	{
		$friendly_name = fRequest::get('name', 'string');
		$block = new Block(array('friendly_name' => $friendly_name));
		$block_coords = new fFile(ROOT_PATH.'/opendata/generated/'.$block->getFriendlyName().'.txt');
		$mark = join(',', array(
			$block->getMidPointLongitude(),
			$block->getMidPointLatitude()
		));
		foreach ($block_coords as $point) {
			$points[] = explode(',', $point);
		}
		$path = @encode_polyline($points);
		$this->data['block'] = $block;
		$this->data['mark'] = $mark;
		$this->data['path'] = $path;
	}
}
