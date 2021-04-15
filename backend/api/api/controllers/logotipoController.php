<?php
require_once 'C:\xampp\htdocs\api\api\models\logotipoModel.php';



Class logotipoController{

    private $logotipo;

public function __construct(){
    $this->logotipo = new Logotipos();
}

    public function getAll(){
        
        $data = $this->logotipo->getLogotipos();

        exit(json_encode($data));
    }

    public function getOne($id){
        if(is_array($id)){
            $id = implode('', $id);
        }
        $data = $this->logotipo->getLogotiposById($id);
        if ($data == null) {
            $data = "No hay ningun logotipo";
         }
         exit(json_encode($data));
}

public function insert(){
        if (isset($_FILES['imagen'])) {
        $img = uploadImage('imagen');
        $jsonString = json_encode($_POST);
        $decodedArray = json_decode($jsonString);
        $dataCreate = $this->logotipo->createLogotipos($decodedArray, $img);

    if ($dataCreate) {
        exit(json_encode(array('status' => 'success')));
    } else {
        exit(json_encode(array('status' => 'error')));
    }
}
}

public function update($id){
    if(is_array($id)){
        $id = implode('', $id);
    }
        $data = json_decode(file_get_contents("php://input"));

        $dataUpdate = $this->logotipo->updateLogotipos($id, $data);
        if ($dataUpdate) {
            $this->getOne($id);
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function delete($id){
        if(is_array($id)){
            $id = implode('', $id);
        }
                $data = $this->logotipo->deleteLogotipos($id);

        if (!$data) {
            exit(json_encode("No hay ningun logotipo"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }
}

function uploadImage($imgName)
{

    if (isset($_FILES[$imgName])) {
        $img_tmp = $_FILES[$imgName]['tmp_name'];
        $imgFolder = '../imagenes/';

        if (!file_exists($imgFolder)) {
            mkdir($imgFolder, 0777, true);
        }


        if (file_exists($img_tmp)) {
            $taille_maxi = 100000;
            $taille = filesize($_FILES[$imgName]['tmp_name']);
            $imgsize = getimagesize($_FILES[$imgName]['tmp_name']);
            $extensions = array('.png', '.gif', '.jpg', '.jpeg');
            $extensions = strtolower(strrchr($_FILES[$imgName]['name'], '.'));

            if ($imgsize['mime'] == 'image/jpeg') {
                $img_src = imagecreatefromjpeg($img_tmp);
            } elseif ($imgsize['mime'] == 'image/png') {
                $img_src = imagecreatefrompng($img_tmp);
            } else if ($imgsize['mime'] == 'image/gif') {
                $img_src = imagecreatefromgif($img_tmp);
            }
            $new_width = 1920;
            $new_height = 1080;
            $image_finale = imagecreatetruecolor($new_width, $new_height);


            imagecopyresampled($image_finale, $img_src, 0, 0, 0, 0, $new_width, $new_height, $imgsize[0], $imgsize[1]);


            $t = microtime(true);
            $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
            $now = date('dmYHis' . $micro, $t);
            $imgName = $imgFolder . $now . '.png';
            imagejpeg($image_finale, $imgName);
            return $imgName;
        }
    }
}
