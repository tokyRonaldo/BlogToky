<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Media;
use App\Models\Categorie;
use App\Models\Article_categorie;
use App\Models\Commentaire;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use DataTables;

class CommentaireController extends Controller
{
    public function index(Request $request){
        // if ($request->ajax()) {
            $data = Commentaire::latest()->get();
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
                  
                    $html .= '<li><a @click="editerCommentaire" class="edit-commentaire dropdown-item" id="editCommentaire-'.$row->id.'"><i class="fas fa-edit"></i>edit</a></li>';
                    $html .= '<li><a   @click="deleteCommentaire" id="deleteCommentaire-'.$row->id.'" class="delete-commentaire dropdown-item"><i  class="fa fa-trash"></i>delete</a></li>';
                    // $html .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm">edit</a>';
                    $html .= '</ul></div>';
            //     }
            // }
            $html .= '</div>';
            return $html;
                })
                ->addColumn('article', function($row){
                    $article='<div class="name">' .$row->articles->titre.'</div>';
                    return $article;
                })
                ->addColumn('utilisateur', function($row){
                    $user=isset($row->users->name) ? $row->users->name : '';
                    $utilisateur='<div class="name">' .$user.'</div>';
                    return $utilisateur;
                })
                // ->addColumn('sku', function($row){
                //     $sku='<span>' .$row->sku.'</span>';
                //     return $sku;
                // })
                ->addColumn('commentaire', function($row){
                    $commentaire='<div class="name">' .$row->contenu.'</div>';
                    return $commentaire;
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
               
                ->rawColumns(['action','article','utilisateur','commentaire','created_at','updated_at'])
                // ->rawColumns(['action','nom','prix'])
                ->make(true);
        // }

    }

    public function create(){
        // $allMedia=Media::all();
        // $allCategorie=Categorie::all();
        // $allUser=User::all();
        //  $result=[
        //             'allMedia'=>$allMedia,
        //             'allCategorie'=>$allCategorie,
        //             'allUser'=>$allUser,
        //         ];
        // //    $aprop=Apropos::get();
        // //    $apropos=$aprop->first();

        // return response()->json($result);
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
            $commentaire_detail['article_id']=$request->article_id;
            
            $commentaire_detail['user_id']= isset($request->user()->id) ? $request->user()->id : null;
            $commentaire_detail['contenu']=$request->commentaire;

            $commentaire = Commentaire::create($commentaire_detail);

           
            DB::commit();
            $output = ['success' => 1,
                            'msg' => 'commentaire envoyer'
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

        return response()->json($result);
       
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
        $commentaire=Commentaire::find($id);
        $user = $commentaire->users;
        $article = $commentaire->articles;

        $result=[
                'article'=>$article,
                'user'=>$user,
                'commentaire'=>$commentaire,
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
        $commentaire=Commentaire::find($id);
        try{
            // $commentaire_detail['article_id']=$request->article;
            // $commentaire_detail['user_id']=$request->utilisateur;
            $commentaire_detail['contenu']=$request->commentaire;

            $commentaire->update($commentaire_detail);

            DB::commit();
            $output = ['success' => 1,
                            'msg' => 'editer avec succès'
                        ];
        }
        catch(\Exception $e){
            DB::rollBack();
            // \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                            'msg' =>'erreur!'
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
            $commentaire=Commentaire::find($id);

            $commentaire->delete();

            DB::commit();
            $output = ['success' => 1,
                            'msg' => 'effacer avec succès'
                        ];

        }
        catch(\Exception $e){
            DB::rollBack();
            // \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                            'msg' =>'erreur!'
                        ];
            
        }
         return response()->json($output);
    }

}

