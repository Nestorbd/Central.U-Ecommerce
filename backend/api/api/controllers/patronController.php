<?php
require_once 'models/patronModel.php';


class PatronController
{

    private $patron;

    public function __construct()
    {
        $this->patron = new Patron();
    }

    public function getAll()
    {
        $data = $this->patron->getPatrones();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->patron->getPatronById($id);
        if ($data == null) {
            $data = "No hay ningun patron con id=" . $id;
            exit(json_encode($data));
        } else {
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
            $dataCreate = $this->patron->createPatron($decodedArray, $img);

            if ($dataCreate) {
                $this->getOne($dataCreate);
            } else {
                exit(json_encode(array('status' => 'error')));
            }
        }
    }

    public function update($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = json_decode(file_get_contents("php://input"));

        $dataUpdate = $this->patron->updatePatron($id, $data);
        if ($dataUpdate) {
            $this->getOne($id);
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function delete($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->patron->deletePatron($id);

        if (!$data) {
            exit(json_encode("No hay ningun patron"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function añadirArticulos(){
        $data = json_decode(file_get_contents("php://input"));
        $añadir = $this->patron->añadirArticulos($data);

        if ($añadir) {
            $this->getOne($data->id_patron);
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function añadirTarifas(){
        $data = json_decode(file_get_contents("php://input"));
        $añadir = $this->patron->añadirTarifas($data);

        if ($añadir) {
            $this->getOne($data->id_patron);
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function quitarArticulos(){
        $data = json_decode(file_get_contents("php://input"));
        $añadir = $this->patron->quitarArticulos($data);

        if ($añadir) {
            exit(json_encode(array('status' => 'success')));
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function quitarTarifas(){
        $data = json_decode(file_get_contents("php://input"));
        $añadir = $this->patron->quitarTarifas($data);

        if ($añadir) {
            exit(json_encode(array('status' => 'success')));
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

}

function uploadImage($imgName)
{

    if (isset($_FILES[$imgName])) {
        $img_tmp = $_FILES[$imgName]['tmp_name'];
        $imgFolder = ROOT . 'imagenes' . DS . 'patrones' . DS;

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
