<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function showLogin() {
        return view( 'auth.login' );
    }

    public function login( Request $request ) {
        $data = $request->validate( [
            'email'    => 'required|email',
            'password' => 'required|string',
        ] );

        $user = User::where( 'email', $data['email'] )->first();
        if ( !$user || !Hash::check( $data['password'], $user->password ) ) {
            return back()->withErrors( ['email' => 'Invalid credentials'] )->withInput();
        }

        // store minimal session
        session( ['user_id' => $user->id, 'user_role' => $user->role, 'user_name' => $user->name] );
        return redirect( '/overtime' );
    }

    public function logout() {
        session()->forget( ['user_id', 'user_role', 'user_name'] );
        return redirect( '/login' );
    }
}
