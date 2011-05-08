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
		$blocks = fRecordSet::build('Block', null, array('name' => 'asc'));
		foreach ($blocks as $block) {
			$markers[] = $block->getLonAvg().','.$block->getLatAvg();
		}
		$this->data['blocks'] = $blocks;
		$this->data['markers'] = join('&markers=', $markers);
		
	}
	
	public function show()
	{
		$friendly_name = fRequest::get('name', 'string');
		$block = new Block(array('friendly_name' => $friendly_name));
		$block_coords = new fFile(ROOT_PATH.'/opendata/generated/'.$block->getFriendlyName().'.txt');
		$marker = join(',', array(
			$block->getLonAvg(),
			$block->getLatAvg()
		));
		foreach ($block_coords as $point) {
			$points[] = explode(',', $point);
		}
		$path = @encode_polyline($points);
		$this->data['block'] = $block;
		$this->data['marker'] = $marker;
		$this->data['path'] = $path;
	}
}
