<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Page;
use App\Models\Media;
use App\Models\Categorie;
use App\Models\Article_categorie;
use App\Models\Commentaire;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use DataTables;

class UserController extends Controller
{
    public function index(Request $request){
        // if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    // $roles = session('roles');
                    $html =
                   
                    
                    '<div class="btn-group"><button  class="btn btn-info dropdown-toggle btn-xs" data-bs-toggle="dropdown" aria-expanded="false">action<span class="caret"></span></button>';
                    // if (isset($roles)){
                    //     if(in_array('admin',$roles) ||in_array('superAdmin',$roles)){
                            $html .= '<ul class="dropdown-menu" role="menu">';
                    
                    // $html .= '<li><a href="'. action('App\Http\Controllers\ProduitController@show', [$row->id]) .'" class="btn-modal view-product-modal" data-toggle="modal" data-target="#view_modal"><i class="fa fa-eye"></i>show</a></li>';
                  
                    $html .= '<li><a @click="editerUser" class="edit-user dropdown-item" id="editUser-'.$row->id.'"><i class="fas fa-edit"></i>edit</a></li>';
                    $html .= '<li><a   @click="deleteUser" id="deleteUser-'.$row->id.'" class="delete-user dropdown-item"><i  class="fa fa-trash"></i>delete</a></li>';
                    // $html .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm">edit</a>';
                    $html .= '</ul></div>';
            //     }
            // }
            $html .= '</div>';
            return $html;
                })
              
                ->addColumn('username', function($row){
                    $username='<div class="username">' .$row->name.'</div>';
                    return $username;
                })
                  ->addColumn('role', function($row){
                    $role='<div class="role">' .$row->role.'</div>';
                    return $role;
                })
                    ->addColumn('password', function($row){
                        $password=$row->password;
                    $password='<div class="password">' .$password.'</div>';
                    return $password;
                })
                ->addColumn('created_at', function($row){
                    $date=$row->created_at;
                    $the_date=date('d-m-Y',strtotime($date));
                    $created_at='<div class="name">' .$the_date.'</div>';
                    return $created_at;
                })
                ->addColumn('updated_at', function($row){
                    $date=$row->updated_at;
                    $the_date=date('d-m-Y',strtotime($date));
                    $updated_at='<div class="name">' .$the_date.'</div>';
                    return $updated_at;
                })
               
                ->rawColumns(['action','username','password','role','created_at','updated_at'])
                // ->rawColumns(['action','nom','prix'])
                ->make(true);
        // }

    }

    public function create(){
         $allUser = User::all();
      
         $result=[
                    'allUser'=>$allUser,
                ];
        //    $aprop=Apropos::get();
        //    $apropos=$aprop->first();

        return response()->json($result);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        try{

            $validate=$request->validate([
                'name' => 'required|unique:users',
                'password' => 'required|min:6|unique:users',
                'role' => 'required|in:admin,user,writer',
                // Autres règles de validation
            ]);

            $user_detail['role']=$request->role;
            $user_detail['name']=$request->name;
            $user_detail['password']=$request->password;
            $user_detail['password']=Hash::make($request->password);

            $user = User::create($user_detail);

           
           
            DB::commit();
            $output = ['success' => 1,
                            'msg' => 'creer avec succès'
                        ];

        }
        catch(\Exception $e){
            DB::rollBack();
            // \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                            'msg' =>"erreur!"
                        ];
        }
         return response()->json($output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
        //    $article=Article::findOrFail($id);
        //    $medias=$article->medias;
        //    $commentaires=$article->commentaires;
        //    $article_categories=$article->article_categories;
        //    $user=$article->users;
        //    $result=['article'=>$article,
        //             'medias'=>$medias,
        //             'commentaires'=>$commentaires,
        //             'article_categories'=>$article_categories,
        //             'user'=>$user
        //         ];
        //    $aprop=Apropos::get();
        //    $apropos=$aprop->first();

        // return response()->json($result);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        // $id =$request->id;
        $user=User::find($id);
        
        // $allArticle = Article::all()->pluck('titre', 'id');
        $result=[
                'user'=>$user,
                ];
        return response()->json($result);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::find($id);
        
        // dd($request);
        try{

            if ($request->password == $user->password) {
                // Le mot de passe correspond au hachage stocké dans la base de données
                // Faites quelque chose ici, comme authentifier l'utilisateur
                
                 if(isset($request->role)){
                    $validate=$request->validate([
                        'role' => 'required|in:admin,user,writer',
                        // Autres règles de validation
                    ]);
                    $user_detail['role']=$request->role;
                }
                $user_detail['password']=$request->password;
            } else {
                $validate=$request->validate([
                    'password' => 'required|min:6|unique:users',
                    // Autres règles de validation
                ]);

                if(isset($request->role)){
                    $validate=$request->validate([
                        'role' => 'required|in:admin,user,writer',
                        // Autres règles de validation
                    ]);
                    $user_detail['role']=$request->role;
                }
                $user_detail['password']=Hash::make($request->password);
            }

            $user_detail['name']=$request->name;

            $user->update($user_detail);

            DB::commit();
            $output = ['success' => 1,
                            'msg' => 'editer avec succès'
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user=User::find($id);

            $user->delete();

            DB::commit();
            $output = ['success' => 1,
                            'msg' => 'effacer avec succès'
                        ];

        }
        catch(\Exception $e){
            DB::rollBack();
            // \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                            'msg' =>'erreur'
                        ];
            
        }
         return response()->json($output);
    }

}

