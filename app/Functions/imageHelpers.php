<?php

use File as File;

function uploadImage($file, $position)
{
    $path = 'admins/uploads/' . $position . '/';
    $file_ext = $file->getClientOriginalExtension();
    $img_name =  substr(md5(time()), 0, 10) . rand(0, 99) . '.' . $file_ext;
    $file->move($path, $img_name);
    return $img_name;
}

function deleteImage($name_img, $position)
{
    $path = 'admins/uploads/' . $position . '/';
    if (File::exists($path . $name_img)) {
        File::delete($path . $name_img);
    };
}

function downloadImage($src, $position)
{
    $img_name =  substr(md5(time()), 0, 10) . rand(0, 99) . '.' . "png";
    $path = 'admins/uploads/' . $position . '/' . $img_name;
    file_put_contents($path, file_get_contents($src));
    return $img_name;
}
