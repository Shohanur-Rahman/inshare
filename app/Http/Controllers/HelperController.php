<?php

namespace App\Http\Controllers;

use App\PDFInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class HelperController extends Controller
{
    public function uploadImage($image, $rootDirectory, $width= null, $height = null)
    {
        $saveURL="";

        if($image){
            $file = $image;
            $originalName = $file->getClientOriginalName();
            $mainFolder = Carbon::now()->format('F_Y');
            $subFolder = Carbon::now()->format('d');
            $destinationPath = $rootDirectory;// . $mainFolder .'/'. $subFolder.'/';

            $fileName = time().'_'.$originalName;
            $saveURL = $destinationPath . $fileName;

            if (!is_dir(public_path($destinationPath))) {
                mkdir(public_path($destinationPath), 0755, true);
            }

            if($width && $height){

                Image::make($image)->resize($width,$height)->save(public_path($saveURL));

            }else{

                $file->move(public_path($destinationPath),$fileName);
            }

        }

        return $saveURL;
    }

    public function moveLibraryFileToStorageLocation()
    {
        $this->movePublicFile('pdf');
         $this->movePublicFile('files');
    }

     public function movePublicFile($fileType)
    {
        $destinationPath = public_path('library/'.Auth::user()->company_name.'/'.$fileType.'/');
        $fileList = File::allFiles($destinationPath);




        foreach ($fileList as $aFile) {
            $appName="";
            $fileName="";
            $filename = $aFile->getFilename();

            $myArray = explode('_', $filename);

            $appName=$myArray[0];
            $fileName=$myArray[1];

            $storagePath = 'public/applications/'.Auth::user()->company_name.'/'. $fileType.'/'.$appName.'/';



            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath, 0775, true);
            }


            $fileURL = storage_path('app/'.$storagePath . "/" . $fileName);

            File::move($aFile, $fileURL);

        }
    }
}
