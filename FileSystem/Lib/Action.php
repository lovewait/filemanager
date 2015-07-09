<?php
class Action{
    public $action_name;
    public $model_name;
    public $tpl_name;
    private $tpl_file;
    private $_data;
    protected $content;
    public function __construct(){
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
        if(preg_match_all('/(<\?php\s(.*?)\?>?)/s',$this->content,$match)){
            $find = $match[1];
            $_replace = array();
            foreach($match[2] as $_match){
                eval($_match);
                $_replace[] = ob_get_contents();
                ob_clean();
            }
            ob_flush();
            str_replace($find,$_replace,$this->content,$i);
        }
        header('Content-type:text/html;charset=UTF-8');
        var_dump($this->content);
        var_dump($match[1]);
        var_dump($i);
        ob_end_flush();
    }
}