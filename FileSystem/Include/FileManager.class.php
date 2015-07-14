<?php
class FileManager{
    private $_debug=array();
    private $_msg = '';
    private $_dir = '';
    private $_file = '';
    public function readDir($dir){
        $filehandle = opendir(realpath($dir));
        $file_list = array();
        while(($file = readdir($filehandle))!== false){
            if($file == '.' || $file == '..'){
                continue;
            }
            $data['name'] = $file;
            $data['size'] = filesize($dir.'/'.$file);
            $data['type'] = is_dir($dir.'/'.$file) ? 'folder' : 'file';
            $file_list[]= $data;
        }
        closedir($filehandle);
        return $file_list;
    }
    public function deleteAll($dir){
        if(is_dir($dir)){
            return $this->deleteDir($dir,true);
        }elseif(is_file($dir)){
            return $this->deleteFile($dir);
        }
    }
    public function deleteDir($dir,$force=false){
        if(!is_dir($dir)){
            return false;
        }
        //多级删除时避免文件句柄重名导致删除失败
        $filehandle[] = opendir(realpath($dir));
        $this->_dir = $dir;
        while(($file = readdir($filehandle[count($filehandle)-1]))!== false){
            if($file == '.' || $file == '..'){
                continue;
            }
            if((is_file($dir.'/'.$file) || is_dir($dir.'/'.$file)) && !$force){
                $this->_msg = '文件夹不为空!!!';
                return false;
            }
            if(is_file($dir.'/'.$file)){
                if(!$this->deleteFile($dir.'/'.$file)){
                    $this->_msg = '删除文件'.$this->_file.'失败';
                    return false;
                }
            }
            if(is_dir($dir.'/'.$file)){
                if(!$this->deleteDir($dir.'/'.$file,$force)){
                    $this->_msg = '删除文件夹'.$this->_dir.'失败';
                    return false;
                }
            }
        }
        closedir($filehandle[count($filehandle)-1]);
        rmdir($dir);
        return true;
    }
    public function deleteFile($file){
        $this->_file = $file;
        if(!is_file($file)){
            $this->_msg = $this->_file.'不是合法文件';
            return false;
        }
        unlink($file);
        return true;
    }
    public function getDebug(){
        $this->_debug['file'] = $this->_file;
        $this->_debug['dir'] = $this->_dir;
        $this->_debug['msg'] = $this->_msg;
        return $this->_debug;
    }
}