<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alamat;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        $user = User::find(Auth::user()->id);
        $alamats = Alamat::where('user_id','=',$user->id)->get();
        $progressValue = $this->getUserProgress($user);
        // dd($progressValue);

        return view('pages.customer.profile', ['user'=>$user, 'alamats'=>$alamats, 'progress_value'=>$progressValue]);
    }

    public function getUserProgress($user) {
        if($user->points <= 0) {
            $valueProgress = 0;
        } else if($user->points >= 0 && $user->points < 300) {
            $valueProgress = ((300 - $user->points)/300) * 100;
        } else {
            $valueProgress = 100;
        }
        return $valueProgress;
    }
}
