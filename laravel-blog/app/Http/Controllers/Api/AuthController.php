<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validez et créez un nouvel utilisateur
        // ...
        try{
            
            $validate=$request->validate([
                'name' => 'required|min:6|unique:users',
                'password' => 'required|min:6:users',
                // Autres règles de validation
            ]);

            //verifier si la premiere fois qu 'on register
            $checkUser=User::All();
            $nbreUser=$checkUser->count();
            if($nbreUser < 1){
                $role="admin";
            }
            else{
                $role="user";
            }
            $user = User::create([
                'name' => $request->name,
                'role' => $role,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            DB::commit();
            $token = $user->createToken('api-token')->plainTextToken;
            $output = ['success' => 1,
                            'msg' => 'creer avec succès',
                            'token' => $token
                        ];

        }
        catch(\Exception $e){
            DB::rollBack();
            // \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                            'msg' =>$e->getMessage()
                        ];
        }
        return response()->json($output);
        
        // Créez un token d'API pour l'utilisateur
        // $token = $user->createToken('api-token')->plainTextToken;

        // return response()->json(['token' => $token], 201);
    }

    public function login(Request $request)
    {
        // Validez les informations de connexion
        // ...

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $user = User::where('name', $request->name)->first();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}