<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $userInfo = User::find(Auth::id());

        $arrayData=0;

        $destinationPath = 'public/applications/'.Auth::user()->company_name.'/pdf/';

        $filePath = 'library/'.Auth::user()->company_name.'/';

         if (!is_dir(public_path($filePath))) {
                mkdir(public_path($filePath), 0755, true);
            }


        if (!Storage::exists($destinationPath)) {
            Storage::makeDirectory($destinationPath, 0775, true);
        }

        $directoryList = array_map('basename', Storage::directories($destinationPath));


        $raApplication = 0;
        foreach ($directoryList as $key) {
            $applicationList = array_map('basename', Storage::files($destinationPath.$key));
  
            $raApplication += count($applicationList);
        }


        $arrayData= $raApplication;

        return view('admin.dashboard', compact('userInfo', 'arrayData'));
    }


    public function get_directory_pie_chart_data()
    {
        $arrayData = array();
        $destinationPath = 'public/applications/'.Auth::user()->company_name.'/pdf/';
        if (!Storage::exists($destinationPath)) {
            Storage::makeDirectory($destinationPath, 0775, true);
        }
        $directoryList = array_map('basename', Storage::directories($destinationPath));


        foreach ($directoryList as $key) {
            $applicationList = array_map('basename', Storage::files($destinationPath.'/'.$key));
            if(count($applicationList) > 0)
            array_push($arrayData, ['folder_name' => $key, 'total_count' => count($applicationList)]);
        }
        return response()->json($arrayData);
    }
}
