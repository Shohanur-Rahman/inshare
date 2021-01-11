<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AccountsController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {

        $helper = new HelperController();
        $data = request()->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'required_with:password_confirmation', 'same:password_confirmation'],
            ]
        );

        Session::put('register-session', $data['email']);

        /*
        *
        * Upload featured image and return path url */
        $fileURL = $helper->uploadImage($request->file('company_image'), 'uploads/company/', 220, 80);
        $companyName = $request->company_name;



        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'company_logo' => $fileURL,
            'company_name' => $companyName,
        ]);

        $email = $data['email'];
        $password = $data['password'];


        $attempts = ['email' => $email, 'password' => $password];

        if (Auth::attempt($attempts)) {
            return redirect()->route('dashboard')->with('success-message', 'registration successfully complete. Please Check Your Email!!');
        }


        return redirect()->back()->with('success-message', 'registration successfully complete. Please Check Your Email!!');
    }
}
