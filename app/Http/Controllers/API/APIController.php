<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $allUsers =  User::get();
        return response()->json($allUsers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        //
        // dd($req);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        //
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 404);
        }

        $newUser = new User();
        $newUser->name = $req->name;
        $newUser->email = $req->email;
        $newUser->password = $req->password;

        if($newUser->save()){
            return response()->json($req->all(), 200);
        }
        else {
            return response()->json("Some error occured...", 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        if($user){
            return response()->json($user, 200);
        }
        else {
            return response()->json("User doesn't exist", 404);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
        //
        try {
            $user = User::find($id);
        
            if($user){
                $validator = Validator::make($req->all(), [
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:8',
                ]);

                if($validator->fails()){
                    return response()->json($validator->messages(), 404);
                }
                else {
                    $user->name = $req->name;
                    $user->email = $req->email;
                    $user->password = $req->password;
                    
                    if($user->save()){
                        return response()->json("User updated...", 200);
                    }
                    else {
                        return response()->json("Error updating user!", 404);
                    }
                }
            }
            else {
                return response()->json("User not found!", 404);
            }
        } catch (\Exception $th) {
            return response()->json("Error: ". $th, 404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $user = User::find($id);

            if($user){
                if($user->delete()){
                    return response()->json("User deleted...", 200);
                }
                else {
                    return response()->json("Error deleting user!", 404);
                }
            }
            else {
                return response()->json("User not found!", 404);
            }
        }
        catch(\Exception $err){
            return response()->json("Error: ". $err, 404);
        }
    }

    public function changePassword(Request $req, $id){
        try{
            $user = User::find($id);
            // return response()->json($user);
            // die;
            if($user){
                if(Hash::check($req->old_password, $user->password)){
                    $user->password = $req->new_password;
                    if($user->save()){
                        return response()->json("Password changed...", 200);
                    }
                    else {
                        return response()->json("Error changing password!", 500);
                    }
                }
                else {
                    return response()->json("Password doesn't match!", 500);
                }
            }
            else {
                return response()->json("User not found!", 404);
            }
        }
        catch(\Exception $err){
            return response()->json("Internal server error", 500);
        }
    }
}
