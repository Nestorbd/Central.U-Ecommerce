<?php
require_once 'models/bocetoModel.php';


class BocetoController
{

    private $boceto;

    public function __construct()
    {
        $this->boceto = new Boceto();
    }

    public function getAll()
    {
        $data = $this->boceto->getBocetos();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->boceto->getBocetoById($id);
        if ($data == null) {
            $data = "No hay ningun boceto con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
        }
        
    }

    public function insert()
    {
        if (isset($_FILES['imagen'])) {
            $img = uploadImage('imagen');
            $jsonString = json_encode($_POST);
            $decodedArray = json_decode($jsonString);
            $dataCreate = $this->boceto->createBoceto($decodedArray, $img);

            if ($dataCreate) {
                $this->getOne($dataCreate);
            } else {
                exit(json_encode(array('status' => 'error')));
            }
        }
        
    }

    public function delete($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->boceto->deleteBoceto($id);

        if (!$data) {
            exit(json_encode("No hay ninguna boceto"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function getBocetosByPedido($id){
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->boceto->getBocetosByPedido($id);
        if (!$data) {
            exit(json_encode("este pedido no tiene ningun boceto asignado"));
        } else {
            exit(json_encode($data));
        }
    }
}
function uploadImage($imgName)
{

    if (isset($_FILES[$imgName])) {
        $img_tmp = $_FILES[$imgName]['tmp_name'];
        $imgFolder = ROOT . 'imagenes' . DS . 'bocetos' . DS;

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
            $new_width = 400;
            $new_height = 380;
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