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
}
