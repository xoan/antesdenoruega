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
		$sports = fRecordSet::build('Sport', null, array('name' => 'asc'));
		foreach ($sports as $sport) {
			$markers[] = $sport->getLon().','.$sport->getLat();
		}
		$this->data['sports'] = $sports;
		$this->data['markers'] = join('&markers=', $markers);
	}
	
	public function show()
	{
		global $database;
		$sport = new Sport(fRequest::get('id'));
		$marker = $sport->getLat().','.$sport->getLon();
		// lat, lon, lat
		$query = 'SELECT id, (6371 * acos(cos(radians(%f)) * cos(radians(lat_avg)) * cos(radians(lon_avg) - radians(%f)) + sin(radians(%f)) * sin(radians(lat_avg)))) AS distance FROM blocks HAVING distance < 2 ORDER BY distance LIMIT 0, 1';
		$result = $database->query($query, $sport->getLat(), $sport->getLon(), $sport->getLat());
		$block = new Block($result->fetchScalar());
		$path = get_encoded_polyline($block->getFriendlyName());
		$this->data['sport'] = $sport;
		$this->data['marker'] = $marker;
		$this->data['path'] = $path;
	}
}
