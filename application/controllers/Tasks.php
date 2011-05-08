<?php
class Tasks extends MoorActionController
{
	protected function afterAction()
	{
		echo Moor::getActiveCallback().' executed.';
	}
	
	public function generate_blocks_data()
	{
		global $database;
		$sql = new fFile(ROOT_PATH.'/database/blocks.sql');
		$database->execute($sql->read());
		$opendata_dir = ROOT_PATH.'/opendata';
		exec('rm '.$opendata_dir.'/generated/*');
		exec('sed -i -e s/UTF-8/ISO-8859-1/g '.$opendata_dir.'/Barrios_AC.kml'); // change encoding declaration
		exec('sed -i -e s/xmlns:xmlns/xmlns/g '.$opendata_dir.'/Barrios_AC.kml'); // fix xmlns
		$reduntant_kml_blocks = array(
			12, // cances (also in "cances - a silva")
			25, // santa xema (also in "palavea - santa xema")
			34, // birloque (duplicated entry)
			37, // mesoiro - feans (separated in "mesoiro" and "feans")
			47, // vioño (also in "sagrada familia - vioño")
			48, // birloque - someso (separated in "birloque" and "someso")
			51, // cidade xardin - paseo das pontes (separated in "cidade xardin" and "paseo das pontes")
	
		);
		$kml = simplexml_load_file($opendata_dir.'/Barrios_AC.kml');
		foreach ($kml->Document->Placemark as $placemark) {
			$simpledata = $placemark->ExtendedData->SchemaData->SimpleData;
			$coordinates = $placemark->Polygon->outerBoundaryIs->LinearRing->coordinates;
			// remove redundant and empty blocks
			if (!in_array($simpledata[0], $reduntant_kml_blocks) and !empty($simpledata[1])) {
				$file = $opendata_dir.'/generated/'.fURL::makeFriendly($simpledata[1]).'.txt';
				foreach (explode(' ', $coordinates) as $point) {
					$points[] = round_and_reverse_coords($point);
				}
				file_put_contents($file, join("\n", $points));
				unset($points);
				$block = new Block();
				$block->setName($simpledata[1]);
				$block->setFriendlyName(fURL::makeFriendly($simpledata[1]));
				$block->store();
			}
		}
	}
	
	public function update_blocks_coords()
	{
		$blocks_dir = new fDirectory(ROOT_PATH.'/opendata/generated');
		$files = $blocks_dir->scan('*.txt');
		foreach ($files as $file) {
			$total = $lon_sum = $lat_sum = 0;
			foreach ($file as $coord) {
				list($lon, $lat) = explode(',', $coord);
				$lon_sum += $lon;
				$lat_sum += $lat;
				$total++;
			}
			$block = new Block(array('friendly_name' => substr($file->getName(), 0, -4)));
			$block->setLonAvg($lon_sum / $total);
			$block->setLatAvg($lat_sum / $total);
			$block->store();
		}
	}
	
	public function generate_sport_centers_data()
	{
		global $database;
		$sql = new fFile(ROOT_PATH.'/database/sports.sql');
		$database->execute($sql->read());
		$base_url = 'http://www.coruna.es';
		$links[0]  = $base_url.'/servlet/Satellite?argIdCat=1113304696048&argIdRootCat=1113304692453&argTipoCat=Entidad&c=Page&cid=1162774846049&pagename=Portal%2FPage%2FPortal-ListadoConBusqueda';
		$doc = phpQuery::newDocument(get_data($links[0]));
		$pages = pq('#paginadorSuperior ul li:has(a) a');
		foreach ($pages as $page)
			$links[] = $base_url.pq($page)->attr('href');
		unset($doc);
		foreach ($links as $link) {
			$doc = phpQuery::newDocument(get_data($link));
			$sport_centers = pq('#unaCategoriaList dl');
			foreach(pq('dt', $sport_centers) as $sport_center) {
				$center_name = pq('a', $sport_center)->text();
				$center_location = str_replace(array(
					' s/n', ' Bj.', ' Bloque'
				), '', trim(pq($sport_center)->next()->find('.geoLocalizacion')->text()));
				if (strlen($center_location) > 0) {
					$sport = new Sport();
					$sport->setName($center_name);
					$sport->setLocation($center_location);
					$sport->store();
				}
			}
		}
	}
	
	public function update_sport_centers_coords()
	{
		$base_url = 'http://maps.googleapis.com/maps/api/geocode/json?address=';
		$sports = fRecordSet::build('Sport');
		foreach ($sports as $sport) {
			$results = json_decode(get_data($base_url.urlencode($sport->getLocation()).'&sensor=false'));
			foreach ($results->results as $result) {
				$location = $result->geometry->location;
				$sport->setLon($location->lng);
				$sport->setLat($location->lat);
				$sport->store();
			}
		}
	}
}
