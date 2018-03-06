<?php
/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {

    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function ftpconnect() {
        global $conn_id;
        /* $ftp_server="ftp.essindia.net";
          $ftp_user="epch@essindia.net";
          $ftp_pass="epch123"; */
        $ftp_server = "192.168.0.108";
        $ftp_user = "epch";
        $ftp_pass = "xyz_abc@123";
        // set up a connection or die
        $conn_id = ftp_connect($ftp_server) or die("{'error':'Couldn't connect to " . $ftp_server . "'}");
        // try to login
        @ftp_login($conn_id, $ftp_user, $ftp_pass) or die("{'error':'Couldn't login to " . $ftp_user . "'}");
    }

    function save($path, $ext) {
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
               if ($realSize != $this->getSize()) {
               return false;
        }
	$path = $path . '.' . $ext;
	$target = fopen($path, "w");
	fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
	return true;
      }

    function getName() {
        return $_GET['qqfile'];
    }

    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])) {
            return (int) $_SERVER["CONTENT_LENGTH"];
        } else {
            throw new Exception('Getting content length is not supported.');
        }
    }

    function downloadfile($filepath, $filename) {
        global $conn_id;
        $this->ftpconnect();
        $ext = '';
        $file_extenstion = explode(".", $filepath);
        $ext = end($file_extenstion);
        $filename = $filename . rand() . '.' . $ext;
        if (ftp_get($conn_id, $filename, $filepath, FTP_BINARY)) {
            $this->getfile($filename);
        } else {
            die("Some Error occured.");
        }
        ftp_close($conn_id);
    }

    function downloadlocalfile($filepath, $filename) {
        $ext = '';
        $file_extenstion = explode(".", $filepath);
        $ext = end($file_extenstion);
        $filename = $filename . rand() . '.' . $ext;
        if (rename($filepath, $filename)) {
            $this->getfile($filename);
        }
    }

    function downloadzipfile($arrfilepath, $filename) {
        global $conn_id;
        $this->ftpconnect();
        $ext = '';
        $flag = false;
        $i = 0;
        foreach ($arrfilepath as $filepath) {
            $file_extenstion = explode(".", $filepath);
            $ext = end($file_extenstion);
            $nfilename = $filename . $i . '.' . $ext;
            if (ftp_get($conn_id, $nfilename, $filepath, FTP_BINARY)) {
                $flag = true;
            } else {
                die("Some Error occured creating zip file.");
            }
            $i++;
        }
        ftp_close($conn_id);
        return $flag;
    }

    function getfile($filename) {

        $allowed_ext = array(
            // archives
            'zip' => 'application/zip',
            // documents
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/msword',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'txt' => 'application/txt',
            // executables
            'exe' => 'application/octet-stream',
            // images
            'gif' => 'image/gif',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            // audio
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/x-wav',
            // video
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mpe' => 'video/mpeg',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo'
        );

        if (!is_file($filename))
            die("File does not exist. Make sure you specified correct file name.");
        $fsize = filesize($filename);
        $fext = strtolower(substr(strrchr($filename, "."), 1));
        if (!array_key_exists($fext, $allowed_ext))
            die("Not allowed file type.");
        if ($allowed_ext[$fext] == '') {
            $mtype = '';
            // mime type is not set, get from server settings
            if (function_exists('mime_content_type')) {
                $mtype = mime_content_type($filename);
            } else if (function_exists('finfo_file')) {
                $finfo = finfo_open(FILEINFO_MIME); // return mime type
                $mtype = finfo_file($finfo, $filename);
                finfo_close($finfo);
            }
            if ($mtype == '') {
                $mtype = "application/force-download";
            }
        } else {
            // get mime type defined by admin
            $mtype = $allowed_ext[$fext];
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: $mtype");
        header("Content-Disposition: attachment; filename=" . basename($filename));
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $fsize);
        ob_clean();
        $file = @fopen($filename, "rb");
        if ($file) {
            while (!feof($file)) {
                print(fread($file, 1024 * 8));
                flush();
                if (connection_status() != 0) {
                    @fclose($file);
                    die();
                }
            }
            @fclose($file);
        }
    }

}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {

    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function ftpconnect() {
        global $conn_id;
        /* $ftp_server = "ftp.essindia.net";
          $ftp_user = "epch@essindia.net";
          $ftp_pass = "epch123"; */
        $ftp_server = "192.168.0.108";
        $ftp_user = "epch";
        $ftp_pass = "xyz_abc@123";
        // set up a connection or die
        $conn_id = ftp_connect($ftp_server) or die("{'error':'Couldn't connect to " . $ftp_server . "'}");
        // try to login
        @ftp_login($conn_id, $ftp_user, $ftp_pass) or die("{'error':'Couldn't login to " . $ftp_user . "'}");
    }

    function save($filename, $prefix, $file_path, $path, $ext) {
        $path = $path . '.' . $ext;
	//echo $_FILES['qqfile']['tmp_name'];
	//echo $_FILES['qqfile']['tmp_name'];
        if (!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)) {
            return false;
        }
        //my
        global $conn_id;
        $file_path = strtolower($file_path);
        $current_timestamp = date("Y-m-d-h-i-s");
        $filename = str_replace("#", "hash", $filename);
        $filename = str_replace("$", "dollar", $filename);
        $filename = str_replace("%", "Percent", $filename);
        $filename = str_replace("^", "", $filename);
        $filename = str_replace("&", "and", $filename);
        $filename = str_replace("*", "", $filename);
        $filename = str_replace("?", "", $filename);
        //$this->ftpconnect();
        $explode_directory_root = explode("/", $file_path);
        $last_array_value = end($explode_directory_root);
        $directory_path = "/";
        $full_path = $directory_path . $file_path;
        $file_extenstion = explode(".", $filename);
       //echo "F.P= " .$full_path."FN= ".$filename; die;
//        if (@ftp_chdir($conn_id, $full_path)) {
//            if (ftp_put($conn_id, $filename, $path, FTP_BINARY)) {
//                return true;
//            } else {
//                return false;
//            }
//        } else {
//            for ($i = 0; $i < count($explode_directory_root); $i++) {
//                if ($explode_directory_root[$i] != "") {
//                    $directory_path.=$explode_directory_root[$i];
//                    if (!@ftp_chdir($conn_id, $directory_path)) {
//                        $create_directory = ftp_mkdir($conn_id, $directory_path);
//                    }
//                    $directory_path = $directory_path . "/";
//                }
//            }
            //ftp_chdir($conn_id, $create_directory);
//            if (ftp_put($conn_id, $filename, $path, FTP_BINARY)) {
//                return true;
//            } else {
//                return false;
//            }
       // }
        //ftp_close($conn_id);
    }

    function getName() {
        return $_FILES['qqfile']['name'];
    }

    function getSize() {
        return $_FILES['qqfile']['size'];
    }

}

class qqFileUploader {

    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760) {
        $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;

        $this->checkServerSettings();

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false;
        }
    }

    private function checkServerSettings() {
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit) {
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");
        }
    }

    private function toBytes($str) {
        $val = trim($str);
        $last = strtolower($str[strlen($str) - 1]);
        switch ($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handledownload($filepath, $file='') {
        $file == '' ? basename($filepath) : $file;
        $this->file = new qqUploadedFileXhr();
        $this->file->downloadfile($filepath, $file);
        exit;
    }

    function handlemultipaldownload($filepath, $file='') {
        $file == '' ? basename($filepath) : $file;
        $this->file = new qqUploadedFileXhr();
        return $this->file->downloadzipfile($filepath, $file);
        exit;
    }

    function handlelocalfile($filepath, $file='') {
        $file == '' ? basename($filepath) : $file;
        $this->file = new qqUploadedFileXhr();
        $this->file->downloadlocalfile($filepath, $file);
        exit;
    }

    function handleUpload($uploadDirectory, $replaceOldFile = FALSE, $foldername, $empid, $prefix='') {

        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        $ext = $pathinfo['extension'];
        if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)) {
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of ' . $these . '.');
        }

        $filename = $uploadDirectory . $empid.$filename;
        if ($this->file->save($filename, $ext)) {
          // return array('success' => true, 'newfilename' => $prefix . $newfile_name, 'originalfilename' => $originalfilename, 'fullpath' => $file_path . '/' . $prefix . $newfile_name);
	  return array('success'=>true);
        } else {
            return array('error' => 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
    }

}