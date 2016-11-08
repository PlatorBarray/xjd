<?php
class upload
{
    public $upload_name;
    public $upload_tmp_address;
    public $upload_dir_name='/media/';
    public $upload_server_name;
    public $upload_file_name;
    public $upload_filetype ;
    public $file_type;
    public $file_server_address;
    public $image_w=900; //要显示图片的宽
    public $image_h=350; //要显示图片的高
    public $upload_file_size;
    public $upload_must_size= 500000000; //允许上传文件的大小，自己设置
    function upload_file()
    {
       $this->upload_tmp_address=$_FILES['img']['tmp_name'];
       $this->upload_name = basename($_FILES["img"]["name"]); //取得上传文件名

        $this->upload_filetype =end(explode('.',$this->upload_name));
        $timerand=date("ymdhis");
        $this->upload_file_name=$timerand.'.'.$this->upload_filetype;
        $this->upload_server_name =$this->upload_dir_name.$this->upload_file_name;
        $this->file_type = array("gif","jpg","png","jpeg"); //允许上传文件的类型
        $this->upload_file_size = $_FIELS["img"]["size"]; //上传文件的大小

        if(in_array($this->upload_filetype,$this->file_type))
        {
            if($this->upload_file_size < $this->upload_must_size)
            {
                $this->file_server_address = $_SERVER['DOCUMENT_ROOT'].$this->upload_server_name;

                move_uploaded_file($this->upload_tmp_address,$this->file_server_address);//从temp目录移出
                //echo("<img src=$this->file_server_address width=$this->image_w height=$this->image_h/>"); //显示图片
                return array('file'=>$timerand,'filename'=>$this->upload_file_name,'filepath'=>$this->upload_server_name);

            }
            else
            {
                echo("文件容量太大");
            }
        }
        else
        {
            echo("不支持此文件类型，请重新选择");
        }

    }

}
?>