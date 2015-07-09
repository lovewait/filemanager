<?php
class IndexAction extends Action{
    public function index(){
        //遍历当前目录下的文件及文件夹
        $dir = isset($_GET['dir']) ? trim($_GET['dir']) : '';
        if(empty($dir)){
            $dir = FILE_ROOT;
        }else{
            $dir = FILE_ROOT.'/'.$dir;
        }
        $data = '';
        $filehandle = opendir(realpath($dir));
        while(($file = readdir($filehandle))!== false){
            $data[] = Core::GBK2UTF8($dir.$file);
        }
        $this->assign('data',$data);
        $this->display();
    }
}