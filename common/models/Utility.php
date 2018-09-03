<?php

namespace common\models;

use Yii;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use yii\base\Exception;

class Utility {

    private $_s3;
    public $key;    // AWS Access key
    public $secret; // AWS Secret key
    public $bucket;
    public $lastError = "";

    private function getInstance() {

        if ($this->_s3 === NULL)
            $this->connect();
        return $this->_s3;
    }

    /**
     * Instance the S3 object
     */
    public function connect() {
        $this->_s3 = S3Client::factory([
                    'version' => '2006-03-01',
                    'region' => 'us-east-2',
                    'credentials' => array(
                        'key' => Yii::$app->params['s3_keys']['key'],
                        'secret' => Yii::$app->params['s3_keys']['secret'])
        ]);
//        $this->_s3 = S3Client::factory([
//                    'version' => "2006-03-01",
//                    'key' => Yii::$app->params['s3_keys']['key'],
//                    'secret' => Yii::$app->params['s3_keys']['secret'],
//                    'region' => 'us-east-1',
//                    
//        ]);
    }

    /**
     * Upload file to S3
     * @param string $file path to file on local server
     * @param string $fileName name of file on Amazon. It can include directories.
     * @param null $bucket bucket name. By default use bucket from config
     */
    public function upload($file, $fileName, $bucket = null) {
        if (!$bucket) {
            $bucket = $this->bucket;
        }

        $s3 = $this->getInstance();
        try {
            $s3->putObject(array(
                'Bucket' => $bucket,
                'Key' => $fileName,
                'Body' => fopen($file, 'r'),
                'ACL' => 'public-read',
            ));
        } catch (S3Exception $e) {
            echo $e->getMessage();
            die;
            echo "There was an error uploading the file.\n";
        }
    }

    public function uploadFiles($file_name, $tmp_name, $sizes = "") {

        $bucketUrl = Yii::$app->params['aws']['STATIC_S3_URL'];

        $imageName = '';
        $pos = explode(".", $file_name);
        $imagename = $pos[0];
        $ext = end(explode(".", $file_name));
        $imageName = $this->fn_url2($imagename);
        if (!empty($imageName)) {
            $imageName = uniqid() . '_' . $imageName;
        } else {
            $imageName = uniqid();
        }
        $fileName = $imageName . '.' . $ext;
        $file_saved = move_uploaded_file($tmp_name, Yii::$app->params['aws']['UPLOAD_TEMP_FILE_PATH'] . $fileName);
        $sourcePath = Yii::$app->params['aws']['UPLOAD_TEMP_FILE_PATH'] . $fileName;
        $bucket = 'image';
        $thumbImage = $imageName . '_thumb.' . $ext;
        $file_name_val = $bucket . $thumbImage;

        $sizes = Yii::$app->params['user_image_sizes'];
        foreach ($sizes as $size) {
            if ($size != 200) {
                $thumbImage = $imageName . '_' . $size . '.' . $ext;
            }
            $sourceThumb = Yii::$app->params['aws']['UPLOAD_TEMP_FILE_PATH'] . $thumbImage;
            $this->resize($size, $sourcePath, $sourceThumb);
            // file , fileName , Bucket
            
            $image = $this->upload($sourceThumb, $bucket . $thumbImage, $bucketUrl);
            
            //unlink($sourceThumb);
        }
        //putting in array
        unlink($sourcePath);

        return $file_name_val;
    }

    function createImageons3($dataImage) {
        $imgData = str_replace(' ', '+', $dataImage);
        $imgData = substr($imgData, strpos($imgData, ",") + 1);
        $imgData = base64_decode($imgData);
        // Path where the image is going to be saved
        $imagename = 'twitter-' . uniqid();
        $fileName = $imagename . '.png';
        $sourcePath = Yii::$app->params['aws']['UPLOAD_TEMP_FILE_PATH'] . $fileName;
        // Write $imgData into the image file
        $file = fopen($sourcePath, 'w');
        fwrite($file, $imgData);
        fclose($file);

        // S3 Connection
        $image = $this->upload(Yii::$app->params['aws']['UPLOAD_TEMP_FILE_PATH'] . $fileName, $fileName, 'digital-coders');

//        unlink($sourcePath);
        $revalue = Yii::$app->params['aws']['CDN_URL'] . $fileName;
        return $revalue;
    }

    function resize($newWidth, $originalFile, $targetFile) {

        $info = getimagesize($originalFile);

        list($width, $height) = getimagesize($originalFile);
        $mime = $info['mime'];
        switch (
        $mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;

            default:
                throw Exception('Unknown image type.');
        }

        $img = $image_create_func($originalFile);
        if ($newWidth <= $width) {
            $newHeight = ($height / $width ) * $newWidth;
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }
        $tmp_img = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($tmp_img, false);
        imagesavealpha($tmp_img, true);
        // copy and resize old image into new image
        imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        if ($image_save_func == 'imagejpeg') {
            $thumbFinal = $image_save_func($tmp_img, $targetFile, 100);
        } else {
            $thumbFinal = $image_save_func($tmp_img, $targetFile);
        }
    }

//    public function DBFetchAll($sql, $params = array()) {
//        $command = \Yii::$app->db->createCommand($sql);
//
//        if (!empty($params)) {
//            $dataArray = $command->queryAll($params);
//        } else {
//            $dataArray = $command->queryAll();
//        }
//
//        return $dataArray;
//    }

    function fn_url2($title) {
        $title = str_replace("%", " percentage ", $title);
        $title = str_replace("$", " dollar ", $title);
        $url = preg_replace('/[^a-zA-Z0-9-]/', '-', ltrim(rtrim($title)));
        $url = preg_replace('/[-]+/', '-', $url);
        if (!empty($url)) {
            $url = strtolower($url);
        }
        $url = preg_replace('/[-]+/', '-', $url);
        return $url;
    }

//    public function DBExecute($sql, $params = array()) {
//        $command = \Yii::$app->db->createCommand($sql);
//        $dataArray = $command->execute();
//    }
// for date format
    public function getDateFormatForList($date) {
        if (!empty($date)) {
            $dateFomat = date('d M Y', strtotime($date));
            return $dateFomat;
        }
    }
    public function ellipsis($text, $max = 100, $append = '&hellip;') {
        if (strlen($text) <= $max)
            return $text;
        $out = substr($text, 0, $max - 3);
        if (strpos($text, ' ') === FALSE)
            return (rtrim($out) . $append);
        return preg_replace('/\w+$/', '', rtrim($out)) . $append;
    }

    public function fn_urlid($title) {
        $str = preg_replace('/[^a-zA-Z0-9-]/', '-', trim($title));
        if (!empty($title)) {
            $str = strtolower($str);
        }
        $str = preg_replace('/[-]+/', '-', $str);
        return $str;
    }

    public function fn_url_id($id, $title) {
        $str = preg_replace('/[^a-zA-Z0-9-]/', '-', trim($title));
        if (!empty($title) && !empty($id)) {
            $str = strtolower($str) . '-' . $id;
        } elseif (!empty($title)) {
            $str = strtolower($str);
        } else {
            $str = $id;
        }
        $str = preg_replace('/[-]+/', '-', $str);
        return $str;
    }

//    function to validate the search text and to encode the text of input
    public function validateSearchKeywords($keyword) {
        $valid_keyword = "";
        if (!empty($keyword)) {
            $valid_keyword = htmlspecialchars($keyword);
        }
        return $valid_keyword;
    }

//    for set values in cookies
    public function setCookiesValues($cookieName, $cookieValues) {
        if (!empty($cookieName) && !empty($cookieValues)) {
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => $cookieName,
                'value' => $cookieValues,
            ]));
        }
    }

//    for get values from cookies
    public function getCookiesValues($cookieName) {
        if (!empty($cookieName)) {
            $cookies = Yii::$app->request->cookies;
            // Check the availability of the cookie
            if ($cookies->has($cookieName)) {
                return $cookies->getValue($cookieName);
            }
        }
    }

//    for remove cookies values
    public function removeCookiesValues($cookieName) {
        if (!empty($cookieName)) {
            $cookies = Yii::$app->response->cookies;
            $cookies->remove($cookieName);
            unset($cookies[$cookieName]);
        }
    }

//    for encrypt app key
    public function encryptAppKey($appKey) {
        if (!empty($appKey)) {
            $appKeyLimit = strlen($appKey);

            if ($appKeyLimit > 3) {
                $encryptKey = str_repeat('*', ($appKeyLimit - 4)) . substr($appKey, ($appKeyLimit - 4), 4);
                return $encryptKey;
            } else {
                return $appKey;
            }
        }
    }

//    checking the image is valid or not
    public function isImage($url) {
        $is = @getimagesize($url);
        if ($is) {
            return true;
        } else {
            return false;
        }
    }

    public function uploadImage($file_name, $tmp_name, $sizes = "") {

        $bucket = Yii::$app->params['aws']['STATIC_S3_BUCKET'];
        $bucketUrl = Yii::$app->params['aws']['STATIC_S3_URL'] . $bucket;
        // S3 Connection
        $s3 = new S3(Yii::$app->params['aws']['AWS_ACCESS_KEY'], Yii::$app->params['aws']['AWS_SECRET_KEY']);
        $imageName = '';
        $pos = explode(".", $file_name);
        $imagename = $pos[0];
        $ext = end(explode(".", $file_name));
        $imageName = $this->fn_url2($imagename);
        if (!empty($imageName)) {
            $imageName = uniqid() . '_' . $imageName;
        } else {
            $imageName = uniqid();
        }
        $fileName = $imageName . '.' . $ext;
        $file_saved = move_uploaded_file($tmp_name, Yii::$app->params['aws']['UPLOAD_TEMP_FILE_PATH'] . $fileName);
        $sourcePath = Yii::$app->params['aws']['UPLOAD_TEMP_FILE_PATH'] . $fileName;
        $s3->putObjectFile($sourcePath, $bucketUrl, $fileName, S3::ACL_PUBLIC_READ);
        unlink($sourcePath);
        return $fileName;
    }

    function resizeImg($originalFile, $targetFile) {

        $info = getimagesize($originalFile);

        list($width, $height) = getimagesize($originalFile);
        $mime = $info['mime'];
        switch (
        $mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;

            default:
                throw Exception('Unknown image type.');
        }

        $img = $image_create_func($originalFile);
        if ($width > $height) {
            $newWidth = $width / 2;
            $newHeight = ($height / $width ) * $newWidth;
        } elseif ($height > $width) {
            $newHeight = $height / 2;
            $newWidth = ($width / $height ) * $newHeight;
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }
        $tmp_img = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($tmp_img, false);
        imagesavealpha($tmp_img, true);
        // copy and resize old image into new image
        imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        if ($image_save_func == 'imagejpeg') {
            $thumbFinal = $image_save_func($tmp_img, $targetFile, 100);
        } else {
            $thumbFinal = $image_save_func($tmp_img, $targetFile);
        }
    }

    function formateDate($timestamp) {
        date_default_timezone_set('Asia/Kolkata');
        $date = new \DateTime();
        $date->format('U = Y-m-d H:i:s') . "\n";
        $date->setTimestamp(date($timestamp));
        return $date->format('Y-m-d H:i:s') . "\n";
    }

    function getTimestamp($date = 'now') {
//        $d = new \DateTime($date);
        //$dm = $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
        $dm = new \DateTime($date, new \DateTimeZone('Asia/Kolkata'));
        $dm->format('Y-m-d g:i A');
        $timestamp = $dm->getTimestamp();
        return $timestamp;
    }

}
