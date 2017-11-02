<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileUploaderController extends Controller
{
    public function upload(Request $request)
    {
        if ( !empty( $_FILES ) ) {

            $id= 124;
            $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
            $uploadPath_base =  '../storage/app/Requerimentos/'. $id;

            if(!is_dir($uploadPath_base)){
                //Directory does not exist, so lets create it.
                mkdir($uploadPath_base, 0755, true);
            }

            $uploadPath =  $uploadPath_base. DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];

            move_uploaded_file( $tempPath, $uploadPath );


            $answer = array( 'answer' => 'File transfer completed' );
            $json = json_encode( $uploadPath_base );

            echo $json;

        } else {

            echo 'No files';

        }
    }

    public function insert()
    {

    }
}
