<?php
require ROOT_PATH.'/FileSystem/Include/FileManager.class.php';
class IndexAction extends Action{
    public function index(){
        $filemanager = new FileManager();
        //遍历当前目录下的文件及文件夹
        $current = isset($_SESSION['current']) ? $_SESSION['current'] : FILE_ROOT;
        $current = !empty($_GET['dir']) ? $current.'/'.trim($_GET['dir']) : $current;
        $file_list = $filemanager->readDir($current);
        $_SESSION['file_list'] = $file_list;
        $_SESSION['current'] = $current;
        foreach($file_list as &$file){
            $file['name'] = Core::GBK2UTF8($file['name']);
        }
        $this->assign('file_list',$file_list);
        $this->display();
    }
    public function deletefile(){
        $id = isset($_GET['id']) ? intval($_GET['id']) : '';
        if($_SESSION['current'] && $id !== ''){
            $file_name = $_SESSION['file_list'][$id]['name'];
            $filemanager = new FileManager();
            $file = $_SESSION['current'].'/'.$file_name;
            if($filemanager->deleteAll($file)){
                echo '删除成功!!';
            }else{
                echo '删除失败!!';
            }
        }else{
            echo '文件不存在!!';
        }
        header('Location:?action=Index&method=index');
    }
}