<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Intervention\Image\Facades\Image;
use Livewire\Component;

class BaseComponent extends Component
{
    public function emitNotify($title, $icon = 'success')
    {
        $data['title'] = $title;
        $data['icon'] = $icon;

        $this->emit('notify', $data);
    }

    public function emitShowModal($id)
    {
        $this->emit('showModal', $id);
    }

    public function emitHideModal($id)
    {
        $this->emit('hideModal', $id);
    }

    public function imageWatermark($image , $position = 'bottom-right')
    {
        if (!empty(Setting::getSingleRow('waterMark')) && !is_null(Setting::getSingleRow('waterMark')))
        {
            $img = Image::make(public_path($image));
            $logo = $this->resize_image(public_path(Setting::getSingleRow('waterMark')),250,200);
            $img->insert($logo, $position, 20, 20);

            $img->save(public_path($image));

            $img->encode('png');
            $type = 'png';
            $new_image = 'data:image/' . $type . ';base64,' . base64_encode($img);
        }
    }

    public function resize_image($file, $w, $h, $crop = FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newWidth = $w;
            $newHeight = $h;
        } else {
            if ($w/$h > $r) {
                $newWidth = $h*$r;
                $newHeight = $h;
            } else {
                $newWidth = $w/$r;
                $newHeight = $w;
            }
        }
        $stype = pathinfo($file, PATHINFO_EXTENSION);

        if (in_array($stype,['png','PNG']))
            $src = imagecreatefrompng($file);
        elseif (in_array($stype,['jpeg','JPEG','JPG','jpg']))
            $src = imagecreatefromjpeg($file);
        else
            return $file;

        $dst = imagecreatetruecolor($newWidth, $newHeight);
        switch ($stype) {

            case 'gif':
            case 'png':
                $background = imagecolorallocate($dst , 0, 0, 0);
                imagecolortransparent($dst, $background);
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
                break;
            default:
                break;
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        return $dst;
    }

    public function array_value_recursive($key, array $arr){
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return $val;
    }
}
