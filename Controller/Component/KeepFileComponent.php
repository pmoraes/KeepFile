<?php 

App::uses('Component', 'Controller/Component');
App::uses('FileWrapper', 'KeepFile.Lib');

class KeepFileComponent extends Component
{
	private $controller = null;
	private $fileWrapper = null;
	

	public function __construct(ComponentCollection $collection, $settings = array())
	{
		$this->controller = $collection->getController()->name;
		$this->settings[$this->controller] = $settings;
	}

//Before --beforeFilter
	public function initialize(Controller $controller)
	{
		$this->includeHelper($controller);
		$this->fileWrapper = new FileWrapper($controller->request);
		$this->fileWrapper->createSessionAndRequest($this->settings[$this->controller]);
	}

//After --beforeFilter
	public function startup(Controller $controller) 
	{
		$this->fileWrapper->clearSessionAndFolder();
	}

	public function deleteFilesAndClearSession() 
	{
		$this->fileWrapper->deleteFilesAndClearSession();
	}

	private function includeHelper(Controller $controller)
	{
		$controller->helpers[] = 'KeepFile.FormKeep';
	}
}