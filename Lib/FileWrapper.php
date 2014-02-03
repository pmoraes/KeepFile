<?php 
App::uses('File', 'Utility');

class FileWrapper 
{
	private $request;
	
	public function __construct($request = null) 
	{
		$this->request = $request;
	}
	public function setRequest($request) 
	{
		$this->request = $request;
	}
	
	public function createSessionAndRequest($settings)
	{
		if ($this->request->is('post') && $this->request->data) {
			foreach ($settings as $model => $fields) {
				if ($this->returnFiles($model, $fields)) {
					CakeSession::write('files',$this->returnFiles($model, $fields));
				}
			}
		}
	}

	private function returnFiles($model, $fields) 
	{
		$files = [];
		foreach ($fields as $key => $field) {
			if ($this->request->data[$model][$field]['name']) {
				$files[$model][$field] = $this->moveFile($model, $field);				
			} else {
				$this->request->data[$model][$field] = CakeSession::read('files.'.$model.'.'.$field);
			}
		}

		return $files;
	}

	private function moveFile($model, $field) 
	{
		$tmpFileName = $this->request->data[$model][$field]['tmp_name'];
		$destination = TMP . 'files/' . $this->request->data[$model][$field]['name'];
		$this->request->data[$model][$field]['tmp_name'] = $destination;
		
		move_uploaded_file($tmpFileName, $destination);
		
		return $this->request->data[$model][$field];
	}

	public function deleteFilesAndClearSession() 
	{
		if (CakeSession::check('files')) {
			$files = CakeSession::read('files');

			foreach ($files as $model => $fields) {
				$this->deleteFile($model, $fields);
			}
		}
	}

	private function clearSession($model, $field) 
	{
		CakeSession::delete('files.'.$model.'.'.$field);
	}

	private function deleteFile($model, $fields) 
	{
		foreach ($fields as $field => $contentFile) {
			$this->clearSession($model,$field);		
			$file = new File($contentFile['tmp_name']);
			$file->delete();
		}
	}

	public function clearSessionAndFolder() 
	{
		if ($this->request->is('get')) {
			$this->deleteFilesAndClearSession();
		}
	}
}