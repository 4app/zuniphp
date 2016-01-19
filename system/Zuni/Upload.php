<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;

class Upload {

    private $_path, $_file, $_fileName;

//---------------------------------------------------------------
    /**
     * indica o caminho da pasta/diretorio
     * @param string $path string
     * @return object $this
     */
    public function setPath($path) {
        $this->_path = $path;
        return $this;
    }

//---------------------------------------------------------------
    /**
     * pega o file para upload
     * @param string $file  example: $_FILES['file'];
     * @return object $this
     */
    public function setFile($file) {
        $this->_file = $file;
        $this->_fileName = $this->_file['name'];
        return $this;
    }

    //---------------------------------------------------------------
    /**
     * cria um nome unico
     * podera usar um prefixo com parametro
     * @param string $prefix nome que vai no inicio do file
     */
    public function setFileNameUnique($prefix) {

        $fileUnique = $prefix . substr(md5(uniqid(time())), 0, 15);
        $this->setFileName($fileUnique);
        return $this;
    }

   public function setFileName($name)
    {

    $ex = pathinfo($this->_file['name'], PATHINFO_EXTENSION);
		
        $this->_fileName = $name . '.' .$ex;
        return $this;
    }

   public function getFileName() {
        return $this->_fileName;
    }

//---------------------------------------------------------------
    /**
     * move o file para o destino:
      <pre>
      $u = new \Zuni\Upload(); # instancia a classe
      $u
      ->setPath('path/full/folder/') 
      ->setFile($_FILES['file']) 
      ->moveFile(); # return bool
      </pre>
     * @return bool TRUE|FALSE
     */
    public function moveFile() {

        if (move_uploaded_file($this->_file['tmp_name'], $this->_path . self::getFileName()))
        {
            return TRUE;
        }
            return FALSE;
    }

//---------------------------------------------------------------
    /**
      move a imagem com redirecionamente de tamanho :
      @param $newWidth - define as dimensoes da imagem pela largura
     <pre> 
     $u = new \Zuni\Upload(); # instancia a classe
      $u
      ->setPath('folder/path/') # seta a pasta do file
      ->setFile('file') # = $_FILES['file']
      ->moveFileImage(300); # param 300: largura da imagem
     </pre> 
     */
    public function moveFileImage($newWidth = null) {


        $newWidth = ($newWidth != null) ? (int) $newWidth : 600;


        $folder = $this->_path . self::getFileName();

        $source = imagecreatefromstring(file_get_contents($this->_file['tmp_name']));
        list($width, $height) = getimagesize($this->_file['tmp_name']);
        if ($width > $newWidth) {
            $new_height = ($newWidth / $width) * $height;
            $w_image = imagecreatetruecolor($newWidth, $new_height);
            imagecopyresampled($w_image, $source, 0, 0, 0, 0, $newWidth, $new_height, $width, $height);


            if ($this->_file['type'] == 'image/jpeg'):
                imagejpeg($w_image, $folder, 100);

            elseif ($this->_file['type'] == 'image/gif'):
                imagegif($w_image, $folder, 100);

            elseif ($this->_file['type'] == 'image/png'):
                imagepng($w_image, $folder, 100);
            endif;

            return TRUE;
            
        } else {
            $this->moveFile();
        }
    }

}

// path: Zuni/Helper/Upload.php 
