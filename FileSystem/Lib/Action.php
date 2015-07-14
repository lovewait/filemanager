<?php
class Action{
    public $action_name;
    public $model_name;
    public $tpl_name;
    private $tpl_file;
    private $_data;
    protected $content;
    public function __construct(){
        header('Content-type:text/html;charset=UTF-8');
        $this->action_name = 'index';
        $this->model_name = 'index';
        $this->tpl_name = 'index';
        $this->tpl_file = APP_PATH.'/Tpl/'.ucfirst($this->action_name).'/'.$this->tpl_name.'.html';
        $this->content =  file_get_contents($this->tpl_file);
    }
    public function assign($name,$data){
        $this->_data[$name] = $data;
        $this->content = str_replace('$'.$name,'$this->_data["'.$name.'"]',$this->content);

    }
    public function display(){
        ob_start();
        eval('?>' . $this->content);
        $this->content = ob_get_clean();
        echo $this->content;
    }
}