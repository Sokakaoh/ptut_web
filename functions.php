<?php 

	function getSize($path)
    {

        $image = new Imagick($path);
        $d = $image->getImageGeometry();
        return $d['width'] . 'x' . $d['height'];

    }

 ?>