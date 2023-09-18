<?php
 function createDirecrotory($folder)
{
    if (!file_exists(storage_path().$folder)) {
        mkdir(storage_path().'/'.$folder, 0777, true);
    }
}
?>