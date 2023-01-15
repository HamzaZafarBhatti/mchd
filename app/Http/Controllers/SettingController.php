<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use File;

class SettingController extends Controller
{
    public function setting(){
        $user = auth()->user();
        return view('setting.setting', compact('user'));
    }


    public function updatePassword(Request $request)
    {
        $user = \auth()->user();

        $request->validate([
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'required' => 'The :attribute field is required.',
            'confirmed' => 'New Password should match the Confirm Password',
        ]);

        if (!(Hash::check($request->get('old_password'), $user->getAuthPassword()))) {
            return back()->with("error", "Your Current password does not matches with the password you provided. Please try again.");
        } else {
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                return back()->with('success', 'Password updated successfully!');
            } else {
                return back()->with('error', "Something went wrong!");
            }
        }
    }


    public function change_avatar(Request $request){
        $user = \auth()->user();
        $request->validate([
            'change_avatar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ], [
            'required' => 'The :attribute field is required.',
            'mimes' => "The :attribute field should be jpg, jpeg and png."
        ]);

        try {
            if($user->avatar != "user_default.jpg" && File::exists(public_path('images/'.$user->avatar))){
                File::delete(public_path('images/'.$user->avatar));
            }
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

        $avatar = $request->file('change_avatar');
        $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
        $avatarPath = public_path('/images/');
        $avatar->move($avatarPath, $avatarName);
        $user->avatar =  $avatarName;
        $user->save();
        return redirect()->back()->with('success', "Avatar was changed successfully.");
    }
}
