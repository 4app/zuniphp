<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;

error_reporting(E_ALL ^ E_NOTICE ^ E_USER_NOTICE);

// class canvas{ # classe com nome original
class Canvas {

    private $file, $image, $temp_image;
    private $width, $height, $new_width, $new_height, $html_size;
    private $format, $extension, $size, $basename, $dirname;
    private $rgb = array(255, 255, 255);
    private $quality = 100;
    private $crop_coordinates;
    private $error = "";
    
    //--------------------------------------------------
    /*
     * image_formats:
     * correction for Progressive JPEG" format #1@
     * @author: estefanio Nunes <estefanions@gmail.com>
     * last updade: 2011-04-18 15:40:00
     */

    private $image_formats = array(
        "jpeg" => 2,
        "jpg" => 2,
        "pjpeg" => 2, // #1
        "pjpg" => 2, // #1
        "gif" => 1,
        "png" => 3,
        "bmp" => 6
    );

    function __construct($file = null) {
        if ($file) {
            $this->file = $file;
            $this->image_info();
        }
    }

    function load($file) {
        $this->file = $file;
        $this->image_info();
        if (!$this->error)
            return $this;
        else
            return false;
    }

    function load_url($url) {
        $this->file = $url;
        $this->file_info();
        if (!$this->format) {
            $this->error = "Invalid image URL.";
            return false;
        } else {
            $this->create_image();
            $this->update_dimensions();
            return $this;
        }
    }

    private function image_info() {
        if (is_file($this->file)) {
            $this->file_info();
            if (!$this->is_image())
                $this->error = "Invalid file. {$this->file} is not an image file.";
            else
                $this->create_image();
        }else {
            $this->error = "File not accessible/found.";
        }
    }

    private function dimensions() {
        list($this->width, $this->height, $this->html_size, $this->format) = getimagesize($this->file);
        return $this;
    }

    private function update_dimensions() {
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
        return $this;
    }

    private function file_info() {
        $pathinfo = pathinfo($this->file);
        $this->extension = strtolower($pathinfo["extension"]);
        $this->basename = $pathinfo["basename"];
        $this->dirname = $pathinfo["dirname"];
        $this->format = (isset($this->image_formats[$this->extension]) ? $this->image_formats[$this->extension] : null);
    }

    private function is_image() {
        $this->dimensions();
        if (!$this->format)
            return false;
        else
            return true;
    }

    function create_empty_image($width, $height, $extension = "jpg", $alpha = false) {
        if (!$width || !$height)
            return false;
        $this->width = $width;
        $this->height = $height;
        $this->image = imagecreatetruecolor($this->width, $this->height);
        if ($alpha) {
            imagealphablending($this->image, false);
            imagesavealpha($this->image, true);
            $background_color = imagecolorallocatealpha($this->image, $this->rgb[0], $this->rgb[1], $this->rgb[2], $alpha);
        } else {
            $background_color = imagecolorallocate($this->image, $this->rgb[0], $this->rgb[1], $this->rgb[2]);
        }
        imagefill($this->image, 0, 0, $background_color);
        $this->extension = $extension;
        return $this;
    }

    private function create_image() {
        $extension = ($this->extension == "jpg" ? "jpeg" : $this->extension);
        $function_name = "imagecreatefrom{$extension}";

        if (function_exists($function_name))
            $this->image = $function_name($this->file);
        else
            $this->error = "Invalid image file or imagecreate function not enabled.";

        return $this;
    }

    function set_rgb($rgb) {
        if (is_array($rgb)) {
            $this->rgb = $rgb;
            return $this;
        } elseif ($this->hex_to_rgb($rgb)) {
            return $this;
        } else {
            return false;
        }
    }

    private function hex_to_rgb($hex_color) {
        $hex_color = str_replace("#", "", $hex_color);
        if (strlen($hex_color) == 3) // #fff, #000 etc. 
            $hex_color .= $hex_color;
        if (strlen($hex_color) != 6)
            return false;
        $this->rgb = array(
            hexdec(substr($hex_color, 0, 2)),
            hexdec(substr($hex_color, 2, 2)),
            hexdec(substr($hex_color, 4, 2))
        );
        return $this;
    }

    function set_crop_coordinates($x, $y) {
        $this->crop_coordinates = array($x, $y, $this->width, $this->height);
        return $this;
    }

    function resize($new_width = null, $new_height = null, $method = null) {
        if (!$new_width && !$new_height) {
            $this->error = "Inform a new width and/or a new height.";
            return false;
        } elseif (!is_resource($this->image)) {
            return false;
        }

        $this->new_width = $new_width;
        $this->new_height = $new_height;

        $this->calculate_new_dimensions();

        if ($method)
            $method = "resize_with_{$method}";

        if (!method_exists($this, $method))
            $method = "resize_with_no_method";

        $this->$method()->update_dimensions();
        return $this;
    }

    private function calculate_new_dimensions() {
        $this->check_for_percentages();
        if (!$this->new_width)
            $this->new_width = $this->width / ($this->height / $this->new_height);
        elseif (!$this->new_height)
            $this->new_height = $this->height / ($this->width / $this->new_width);
    }

    private function check_for_percentages() {
        if (strpos($this->new_width, "%"))
            $this->new_width = round($this->width * (preg_replace("/[^0-9]/", "", $this->new_width) / 100));
        if (strpos($this->new_height, "%"))
            $this->new_height = round($this->height * (preg_replace("/[^0-9]/", "", $this->new_height) / 100));
    }

    private function resize_with_no_method() {

        $this->temp_image = imagecreatetruecolor($this->new_width, $this->new_height);

        #
        # correction for background transparent png. 
        # @author: twitter@estefanions
        # last updade: 2011-04-18 15:40:00
        imagesavealpha($this->temp_image, true);
        $trans_colour = imagecolorallocatealpha($this->temp_image, 0, 0, 0, 127);
        imagefill($this->temp_image, 0, 0, $trans_colour);
        # end correction


        imagecopyresampled($this->temp_image, $this->image, 0, 0, 0, 0, $this->new_width, $this->new_height, $this->width, $this->height);
        $this->image = $this->temp_image;
        return $this;
    }

    private function fill() {
        imagefill($this->temp_image, 0, 0, imagecolorallocate($this->temp_image, $this->rgb[0], $this->rgb[1], $this->rgb[2]));
    }

    private function resize_with_fill() {
        $this->temp_image = imagecreatetruecolor($this->new_width, $this->new_height);
        $this->fill();

        // centers image into the filled image area
        // by width
        if (($this->width / $this->height) >= ($this->new_width / $this->new_height)) {
            $dif_w = $this->new_width;
            $dif_h = $this->height * ($this->new_width / $this->width);
            $dif_x = 0;
            $dif_y = round(($this->new_height - $dif_h) / 2);
            // by height
        } else {
            $dif_w = $this->width * ($this->new_height / $this->height);
            $dif_h = $this->new_height;
            $dif_x = round(($this->new_width - $dif_w) / 2);
            $dif_y = 0;
        }

        imagecopyresampled($this->temp_image, $this->image, $dif_x, $dif_y, 0, 0, $dif_w, $dif_h, $this->width, $this->height);
        $this->image = $this->temp_image;
        return $this;
    }

    private function resize_with_crop() {
        if (!is_array($this->crop_coordinates))
            $this->crop_coordinates = array(0, 0, $this->width, $this->height);

        $this->temp_image = imagecreatetruecolor($this->new_width, $this->new_height);

        $this->fill();

        imagecopyresampled($this->temp_image, $this->image, $this->crop_coordinates[0], $this->crop_coordinates[1], 0, 0, $this->crop_coordinates[2], $this->crop_coordinates[3], $this->width, $this->height);

        $this->image = $this->temp_image;
        return $this;
    }

    /**
     * inverte a imagem
     * @param string $orientation valid: horizontal | h | vertical | v
     */
    function flip($orientation = "horizontal") {
        $orientation = strtolower($orientation);

        switch ($orientation) {
            case 'h':
            case 'horizontal':
                $orientation = 'horizontal';
                break;

            case 'v':
            case 'vertical':
                $orientation = 'vertical';
                break;
        }

        if ($orientation != "horizontal" && $orientation != "vertical")
            return false;

        $w = imagesx($this->image);
        $h = imagesy($this->image);
        $this->temp_image = imagecreatetruecolor($w, $h);
        $method = "flip_{$orientation}";
        $this->$method($w, $h);

        $this->image = $this->temp_image;
        return $this;
    }

    private function flip_horizontal($w, $h) {
        for ($x = 0; $x < $w; $x++)
            imagecopy($this->temp_image, $this->image, $x, 0, $w - $x - 1, 0, 1, $h);
    }

    private function flip_vertical($w, $h) {
        for ($y = 0; $y < $h; $y++)
            imagecopy($this->temp_image, $this->image, 0, $y, 0, ($h - $y - 1), $w, 1);
    }

    function rotate($degrees) {
        $background_color = imagecolorallocate($this->image, $this->rgb[0], $this->rgb[1], $this->rgb[2]);

        $this->image = imagerotate($this->image, $degrees, $background_color);

        imagealphablending($this->image, true);
        imagesavealpha($this->image, true);

        $this->update_dimensions();

        return $this;
    }

    function text($text, $options = array()) {
        if (!$text)
            return false;

        if (!isset($options["size"]))
            $options["size"] = 5;

        if (isset($options["color"]))
            $this->set_rgb($options["color"]);

        $text_color = imagecolorallocate($this->image, $this->rgb[0], $this->rgb[1], $this->rgb[2]);
        $dimensions = $this->text_dimensions($text, $options);

        $options["x"] = isset($options["x"]) ? $options["x"] : 0;
        $options["y"] = isset($options["y"]) ? $options["y"] : 0;

        if (is_string($options["x"]) && is_string($options["y"]))
            list($options["x"], $options["y"]) = $this->calculate_position($options["x"], $options["y"], $dimensions["width"], $dimensions["height"]);

        if (isset($options["background_color"]) && $options["background_color"])
            $this->text_background_color($dimensions, $options);

        if (isset($options["truetype"]) && $options["truetype"])
            $this->add_truetype_text($text, $text_color, $options);
        else
            imagestring($this->image, $options["size"], $options["x"], $options["y"], $text, $text_color);

        return $this;
    }

    private function text_dimensions($text, $options) {
        if (isset($options["truetype"]) && $options["truetype"]) {
            $text_dimensions = imagettfbbox($options["size"], 0, $options["font"], $text);
            return array($text_dimensions[4], $options["size"]);
        } else {
            if ($options["size"] > 5)
                $options["size"] = 5;
            return array(
                "width" => imagefontwidth($options["size"]) * strlen($text),
                "height" => imagefontheight($options["size"])
            );
        }
    }

    private function calculate_position($x, $y, $width, $height) {
        switch ($y) {
            case "top":
            default:
                $y = 0;
                break;
            case "bottom":
                $y = $this->height - $height;
                break;
            case "middle":
                switch ($x) {
                    case "left":
                    case "right":
                        $y = ($this->height / 2) - ($height / 2);
                        break;
                    case "center":
                        $y = ($this->height - $height) / 2;
                        break;
                }
                break;
        }

        switch ($x) {
            case "left":
            default:
                $x = 0;
                break;
            case "center":
                $x = ($this->width - $width) / 2;
                break;
            case "right":
                $x = $this->width - $width;
                break;
        }

        return array($x, $y);
    }

    private function text_background_color($dimensions, $options) {
        $this->set_rgb($options["background_color"]);

        $this->temp_image = imagecreatetruecolor($dimensions["width"], $dimensions["height"]);
        $background_color = imagecolorallocate($this->temp_image, $this->rgb[0], $this->rgb[1], $this->rgb[2]);
        imagefill($this->temp_image, 0, 0, $background_color);
        imagecopy($this->image, $this->temp_image, $options["x"], $options["y"], 0, 0, $dimensions["width"], $dimensions["height"]);
    }

    private function add_truetype_text($text, $text_color, $options) {
        imagettftext($this->image, $options["size"], 0, $options["x"], ($options["y"] + $options["size"]), $text_color, $options["font"], $text);
    }

    function merge($image, $position, $alpha = 100) {
        if (!file_exists($image)) {
            $this->error = "Invalid image.";
            return false;
        }
        list($w, $h) = getimagesize($image);

        if (is_string($position[0]) && is_string($position[1]))
            $position = $this->calculate_position($position[0], $position[1], $w, $h);

        $pathinfo = pathinfo($image);
        $extension = strtolower($pathinfo["extension"]);
        $extension = ($extension == "jpg" ? "jpeg" : $extension);
        $function_name = "imagecreatefrom{$extension}";

        if (function_exists($function_name))
            $image_to_merge = $function_name($image);
        else
            $this->error = "Invalid image file or imagecreate function not enabled.";

        list($x, $y) = $position;
        if (is_numeric($alpha) && (($alpha > 0) && ($alpha < 100)))
            imagecopymerge($this->image, $image_to_merge, $x, $y, 0, 0, $w, $h, $alpha);
        else
            imagecopy($this->image, $image_to_merge, $x, $y, 0, 0, $w, $h);

        return $this;
    }

    /**
     * Filtra a imagem
     * @param string $filter param valid: blur, gaussian_blur, 
     * selective_blur, brightness, grayscale, colorize, 
     * contrast, edge, emboss, negate, noise, smooth, pixelate
     */
    function filter($filter, $ammount = 1, $args = array()) {
        if (!function_exists("imagefilter"))
            return false;
        $filter = strtolower($filter);

        switch ($filter) {
            case "blur":
            case "gaussian_blur":
                if (is_numeric($ammount) && $ammount > 1)
                    for ($i = 1; $i <= $ammount; $i++)
                        imagefilter($this->image, IMG_FILTER_GAUSSIAN_BLUR);
                else
                    imagefilter($this->image, IMG_FILTER_GAUSSIAN_BLUR);
                break;
            case "selective_blur":
                if (is_numeric($ammount) && $ammount > 1)
                    for ($i = 1; $i <= $ammount; $i++)
                        imagefilter($this->image, IMG_FILTER_SELECTIVE_BLUR);
                else
                    imagefilter($this->image, IMG_FILTER_SELECTIVE_BLUR);
                break;
            case "brightness":
                imagefilter($this->image, IMG_FILTER_BRIGHTNESS, $args[0]);
                break;
            case "grayscale":
                imagefilter($this->image, IMG_FILTER_GRAYSCALE);
                break;
            case "colorize":
                imagefilter($this->image, IMG_FILTER_COLORIZE, $args[0], $args[1], $args[2], $args[3]);
                break;
            case "contrast":
                imagefilter($this->image, IMG_FILTER_CONTRAST, $args[0]);
                break;
            case "edge":
                if (is_numeric($ammount) && $ammount > 1)
                    for ($i = 1; $i <= $ammount; $i++)
                        imagefilter($this->image, IMG_FILTER_EDGEDETECT);
                else
                    imagefilter($this->image, IMG_FILTER_EDGEDETECT);
                break;
            case "emboss":
                if (is_numeric($ammount) && $ammount > 1)
                    for ($i = 1; $i <= $ammount; $i++)
                        imagefilter($this->image, IMG_FILTER_EMBOSS);
                else
                    imagefilter($this->image, IMG_FILTER_EMBOSS);
                break;
            case "negate":
                imagefilter($this->image, IMG_FILTER_NEGATE);
                break;
            case "noise":
                if (is_numeric($ammount) && $ammount > 1)
                    for ($i = 1; $i <= $ammount; $i++)
                        imagefilter($this->image, IMG_FILTER_MEAN_REMOVAL);
                else
                    imagefilter($this->image, IMG_FILTER_MEAN_REMOVAL);
                break;
            case "smooth":
                if (is_numeric($ammount) && $ammount > 1)
                    for ($i = 1; $i <= $ammount; $i++)
                        imagefilter($this->image, IMG_FILTER_SMOOTH, $args[0]);
                else
                    imagefilter($this->image, IMG_FILTER_SMOOTH, $args[0]);
                break;
            case "pixelate":
                if (is_numeric($ammount) && $ammount > 1)
                    for ($i = 1; $i <= $ammount; $i++)
                        imagefilter($this->image, IMG_FILTER_PIXELATE, $args[0], $args[1]);
                else
                    imagefilter($this->image, IMG_FILTER_PIXELATE, $args[0], $args[1]);
                break;
            default:
                return false;
                break;
        }

        return $this;
    }

    function set_quality($quality) {
        $this->quality = $quality;
        return $this;
    }

    function save($destination) {
        if (!is_dir(dirname($destination))) {
            $this->error = "Invalid destination directory.";
            return false;
        } else {
            return $this->output_image($destination);
        }
    }

    function show() {
        if (headers_sent()) {
            $this->error = "Headers already sent.";
            return false;
        } else {
            header("Content-type: image/{$this->extension}");
            $this->output_image();
            imagedestroy($this->image);
            exit;
        }
    }

    private function output_image($destination = null) {
        $pathinfo = pathinfo($destination);
        $extension = ($pathinfo["extension"] ? strtolower($pathinfo["extension"]) : $this->extension);

        if ($extension == "jpg" || $extension == "jpeg" || $extension == "bmp")
            imagejpeg($this->image, $destination, $this->quality);
        elseif ($extension == "png")
            imagepng($this->image, $destination);
        elseif ($extension == "gif")
            imagegif($this->image, $destination);
        else
            return false;
    }

    /** retorna erro */
    function error_message() {
        return $this->error;
    }

//------------------------------------------------
    /* suporte para a manipulação de arquivos BMP
      +----------------------------------------------+
      | Function: ImageCreateFromBMP                 |
      | Author:   DHKold                             |
      | Contact:  admin@dhkold.com                   |
      | Date:     The 15th of June 2005              |
      | Version:  2.0B                               |
      +----------------------------------------------+

     */

    function imagecreatefrombmp($filename) {
        //Ouverture du fichier en mode binaire
        if (!$f1 = fopen($filename, "rb"))
            return FALSE;

        //1 : Chargement des ent?tes FICHIER
        $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1, 14));
        if ($FILE['file_type'] != 19778)
            return FALSE;

        //2 : Chargement des ent?tes BMP
        $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel' .
                '/Vcompression/Vsize_bitmap/Vhoriz_resolution' .
                '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1, 40));
        $BMP['colors'] = pow(2, $BMP['bits_per_pixel']);
        if ($BMP['size_bitmap'] == 0)
            $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
        $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel'] / 8;
        $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
        $BMP['decal'] = ($BMP['width'] * $BMP['bytes_per_pixel'] / 4);
        $BMP['decal'] -= floor($BMP['width'] * $BMP['bytes_per_pixel'] / 4);
        $BMP['decal'] = 4 - (4 * $BMP['decal']);
        if ($BMP['decal'] == 4)
            $BMP['decal'] = 0;

        //3 : Chargement des couleurs de la palette
        $PALETTE = array();
        if ($BMP['colors'] < 16777216) {
            $PALETTE = unpack('V' . $BMP['colors'], fread($f1, $BMP['colors'] * 4));
        }

        //4 : Cr?ation de l'image
        $IMG = fread($f1, $BMP['size_bitmap']);
        $VIDE = chr(0);

        $res = imagecreatetruecolor($BMP['width'], $BMP['height']);
        $P = 0;
        $Y = $BMP['height'] - 1;
        while ($Y >= 0) {
            $X = 0;
            while ($X < $BMP['width']) {
                if ($BMP['bits_per_pixel'] == 24)
                    $COLOR = @unpack("V", substr($IMG, $P, 3) . $VIDE);
                elseif ($BMP['bits_per_pixel'] == 16) {
                    $COLOR = @unpack("n", substr($IMG, $P, 2));
                    $COLOR[1] = $PALETTE[$COLOR[1] + 1];
                } elseif ($BMP['bits_per_pixel'] == 8) {
                    $COLOR = @unpack("n", $VIDE . substr($IMG, $P, 1));
                    $COLOR[1] = $PALETTE[$COLOR[1] + 1];
                } elseif ($BMP['bits_per_pixel'] == 4) {
                    $COLOR = @unpack("n", $VIDE . substr($IMG, floor($P), 1));
                    if (($P * 2) % 2 == 0)
                        $COLOR[1] = ($COLOR[1] >> 4); else
                        $COLOR[1] = ($COLOR[1] & 0x0F);
                    $COLOR[1] = $PALETTE[$COLOR[1] + 1];
                }
                elseif ($BMP['bits_per_pixel'] == 1) {
                    $COLOR = @unpack("n", $VIDE . substr($IMG, floor($P), 1));
                    if (($P * 8) % 8 == 0)
                        $COLOR[1] = $COLOR[1] >> 7;
                    elseif (($P * 8) % 8 == 1)
                        $COLOR[1] = ($COLOR[1] & 0x40) >> 6;
                    elseif (($P * 8) % 8 == 2)
                        $COLOR[1] = ($COLOR[1] & 0x20) >> 5;
                    elseif (($P * 8) % 8 == 3)
                        $COLOR[1] = ($COLOR[1] & 0x10) >> 4;
                    elseif (($P * 8) % 8 == 4)
                        $COLOR[1] = ($COLOR[1] & 0x8) >> 3;
                    elseif (($P * 8) % 8 == 5)
                        $COLOR[1] = ($COLOR[1] & 0x4) >> 2;
                    elseif (($P * 8) % 8 == 6)
                        $COLOR[1] = ($COLOR[1] & 0x2) >> 1;
                    elseif (($P * 8) % 8 == 7)
                        $COLOR[1] = ($COLOR[1] & 0x1);
                    $COLOR[1] = $PALETTE[$COLOR[1] + 1];
                }
                else
                    return FALSE;
                imagesetpixel($res, $X, $Y, $COLOR[1]);
                $X++;
                $P += $BMP['bytes_per_pixel'];
            }
            $Y--;
            $P+=$BMP['decal'];
        }

        //Fermeture du fichier
        fclose($f1);

        return $res;
    }

}

