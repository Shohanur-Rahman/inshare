<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class ApplicationController extends Controller
{
    public function index()
    {
        $helper = new HelperController();
        $userInfo = User::find(Auth::id());
        $helper->moveLibraryFileToStorageLocation();
        return view('admin.applications.index', compact('userInfo'));
    }

     public function documents()
    {
        $helper = new HelperController();
        $userInfo = User::find(Auth::id());
        $helper->moveLibraryFileToStorageLocation();
        return view('admin.documents.index', compact('userInfo'));
    }


    public function make_zip_download(Request $request)
    {
        $currentDirectory = storage_path('app/' . $request->fullPath);
        // Get real path for our folder
        $rootPath = realpath($currentDirectory);
        //return response()->json($currentDirectory );
        $current_timestamp = Carbon::now()->timestamp;
        $zip_file = $request->folder_name . '_' . $current_timestamp . '.zip';
        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();

        return response()->download($zip_file)->deleteFileAfterSend(true);
    }

    public function download_single_file(Request $request)
    {
        $currentDirectory = $request->fullPath;
        $path = storage_path('app/' . $currentDirectory);
        return response()->download($path);

        //return response()->stream($path);
    }


    public function delete_directory_folder(Request $request)
    {
        $currentDirectory = $request->fullPath;

        if (Storage::exists($currentDirectory)) {
            $response =  Storage::deleteDirectory($currentDirectory);

            if($response == true){
                return redirect()
                    ->back()
                    ->with('message', "Directory deleted successfully");
            }else{
                return redirect()
                    ->back()
                    ->with('warning', "Something wrong");
            }

        }else{
            return redirect()
                ->back()
                ->with('warning', "Directory not found.");
        }

    }


    public function delete_single_file(Request $request)
    {
        $currentDirectory = $request->fullPath;


        if (Storage::exists($currentDirectory)) {
            $response =  Storage::delete($currentDirectory);
            if($response == true){
                return redirect()
                    ->back()
                    ->with('message', "Directory deleted successfully");
            }else{
                return redirect()
                    ->back()
                    ->with('warning', "Something wrong");

            }

        }else{
            return redirect()
                ->back()
                ->with('warning', "Directory not found.");
        }

    }

}
