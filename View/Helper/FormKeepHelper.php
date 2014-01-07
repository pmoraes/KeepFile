<?php
App::uses('Helper', 'View');

class FormKeepHelper extends Helper
{
    public $helpers = array('Form', 'Session');

	public function inputFile($name, $message, $select = "Select File", $change = "Change File") 
	{

        if ($this->Session->check('files.'.$name)) {
            $message = $this->Session->read('files.'.$name.'.name');
            $htmlButton = '<div class="fileinput fileinput-exists" data-provides="fileinput">';

        } else {
			$htmlButton = '<div class="fileinput fileinput-new" data-provides="fileinput">';
        } 

	    $htmlButton .= '<span class="btn btn-default btn-file">
	        <span class="fileinput-new">%s</span>
	        <span class="fileinput-exists">%s</span>
	        %s
        	</span>
        	<span class="fileinput-filename">
        	%s
            </span>
	        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
	        </div>';
        
        $inputFile = $this->Form->text($name,array('type' => 'file'));

        return sprintf($htmlButton,$select,$change,$inputFile,$message);
	}
}