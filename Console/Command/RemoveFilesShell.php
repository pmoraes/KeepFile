<?php 
App::uses('Folder','Utility');
App::uses('File','Utility');
App::uses('Shell','Console');

class RemoveFilesDocumentShell extends Shell
{
	public function main() 
	{
		$this->deleteFiles();
	}

	private function listFiles() 
	{
		$dir = new Folder(TMP . 'files/');
		return $dir->findRecursive('.*',true);
	}

	private function deleteFiles () 
	{	
		$files = $this->listFiles();

		foreach ($files as $key => $value) {
			$timeFile = $this->returnTimeFile($value);
			
			if ($timeFile > $this->timeDelete()) {
				$file = new File($value);
				$file->delete();
			}
		}
	}

	private function timeDelete() 
	{
		$dateTime = new DateTime('now',new DateTimeZone("America/Sao_Paulo"));
		return $dateTime->getTimestamp() - 3600;
	}

	private function returnTimeFile($file) 
	{
		return fileatime($file);
	}
}
