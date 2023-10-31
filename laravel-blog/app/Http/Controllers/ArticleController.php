<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Media;
use App\Models\Page;
use App\Models\Categorie;
use App\Models\Article_categorie;
use App\Models\Commentaire;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use DataTables;

class ArticleController extends Controller
{
    public function index(Request $request){
        // if ($request->ajax()) {
            $data = Article::latest()->get();
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
                  
                    $html .= '<li><a @click="editerArticle" class="edit-article dropdown-item" id="editArticle-'.$row->id.'"><i class="fas fa-edit"></i>edit</a></li>';
                    $html .= '<li><a   @click="deleteArticle" id="deleteArticle-'.$row->id.'" class="delete-article dropdown-item"><i  class="fa fa-trash"></i>delete</a></li>';
                    // $html .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm">edit</a>';
                    $html .= '</ul></div>';
            //     }
            // }
            $html .= '</div>';
            return $html;
                })
                ->addColumn('titre', function($row){
                    $titre='<div class="titre">' .$row->titre.'</div>';
                    return $titre;
                })
                ->addColumn('slug', function($row){
                    $slug='<div class="slug">' .$row->slug.'</div>';
                    return $slug;
                })
                ->addColumn('contenu', function($row){
                    $contenu='<div class="contenu">' .$row->contenu.'</div>';
                    return $contenu;
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
               
                ->rawColumns(['action','titre','slug','contenu','created_at','updated_at'])
                // ->rawColumns(['action','nom','prix'])
                ->make(true);
        // }

        // $data = [
        //     [
        //         "titre" => "titre",
        //         "slug" => "Exemple 1",
        //         "contenu" => "Contenu de l'exemple 1",
        //     ],
        //     [
        //         "titre" => "titre",
        //         "slug" => "Exemple 2",
        //         "contenu" => "Contenu de l'exemple 2",
        //     ],
      

        //     // ... Autres enregistrements
        // ];

        // // La valeur 'draw' envoyée par DataTables dans la requête
        // $draw = $request->input('draw');

        // // Le nombre total d'enregistrements dans l'ensemble de données (avant toute pagination)
        // $recordsTotal = 100;

        // // Le nombre d'enregistrements après filtration et pagination
        // $recordsFiltered = count($data);

        // // Créez le tableau associatif avec les données et les propriétés requises
        // $response = [
        //     "data" => $data,
        //     "draw" => intval($draw),
        //     "recordsTotal" => $recordsTotal,
        //     "recordsFiltered" => $recordsFiltered,
        // ];

        // // Utilisez la méthode json pour retourner les données au format JSON
        // return response()->json($response);
        
    }

    public function create(){
        $allMedia=Media::all();
        $allCategorie=Categorie::all();
        $allUser=User::all();
         $result=[
                    'allMedia'=>$allMedia,
                    'allCategorie'=>$allCategorie,
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
            $article_detail['titre']=$request->titre;
            
            $article_detail['contenu']=$request->contenu;
            $article_detail['user_id']=isset($request->user()->id) ?$request->user()->id :null;

            $slug = generateSlug($request->titre);
            $article_detail['slug']=$slug;

            $article = Article::create($article_detail);

            //table pivot
            $categories=$request->categories;
            foreach($categories as $categorie){
                $article_categorie_detail['categorie_id']=$categorie;
                $article_categorie_detail['article_id']=$article->id;
                $article_categorie_create = Article_categorie::create($article_categorie_detail);
            }
           
            DB::commit();
            $output = ['success' => 1,
                            'msg' => 'creer avec succès'
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
           $article = Article::find($id);
           $medias=$article->medias;
           $article_categories=$article->article_categories;
           $user=$article->users;

            //commentaires
            $commentaires=[];
            $page = Page::first();
            $page_paginate= isset($page->nbre_article) ? $page->nbre_article : 10;
            $comments = Commentaire::where('article_id',$article->id)->paginate($page_paginate);
            // $comments=$article->commentaires->paginate($page_paginate);
            foreach($comments as $index=>$reponse){
                $commentaires[$index]['id']=$reponse->id;
                $commentaires[$index]['article']=$reponse->articles->titre;
                $commentaires[$index]['contenu']=$reponse->contenu;
                $commentaires[$index]['created_at']=$reponse->created_at;
                $commentaires[$index]['user']= isset($reponse->users->name) ? $reponse->users->name : null;
            }
            // return $comments->data->data;
            if(!empty($commentaires)){
            $commentaires['reponses']=$comments;
            }
           $result=['article'=>$article,
                    'media'=>$medias,
                    'commentaires'=>$commentaires,
                    'article_categories'=>$article_categories,
                    'user'=>$user
                ];
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
        $article=Article::find($id);
        $allMedia=Media::all();
        $allCategorie=Categorie::all();
        // $allUser=User::all();
        $medias=$article->medias;
           $commentaires=$article->commentaires;
        //    $article_categories=$article->categories;
        $article_categorie=[];
           $article_categories=$article->article_categories;
           foreach ($article_categories as $article_cat){
            $article_categorie[]=$article_cat->categories;
           }
           
        //    $article_categories=$article->article_categories()->get();
           $user=$article->user_id;
        
        $allUser = User::all()->pluck('username', 'id');
        $result=['article'=>$article,
                'allUser'=>$allUser,
                'user'=>$user,
                'allMedia'=>$allMedia,
                'allCategorie'=>$allCategorie,
                // 'allUser'=>$allUser,
                'commentaires'=>$commentaires,
                'article_categories'=>$article_categorie,
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
        $article=Article::find($id);
        
        // dd($request);
        try{
          
            $article_detail['titre']=$request->titre;
            
            $article_detail['contenu']=$request->contenu;
            // $article_detail['user_id']=$request->input('user');
            $article_detail['user_id']=isset($request->user()->id) ?$request->user()->id :null;

            $slug = generateSlug($request->titre);
            $article_detail['slug']=$slug;

            $article->update($article_detail);

            //table pivot
            $categories=$request->selectedCategories;
            foreach($categories as $categorie){
                $article_categorie = Article_categorie::where('categorie_id',$categorie);
                $article_categorie_detail['categorie_id']=$categorie;
                $article_categorie_detail['article_id']=$article->id;
                $article_categorie_update = $article_categorie->update($article_categorie_detail);
            }

          

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
            $Article=Article::find($id);

            $article_categories=$Article->article_categories;
            foreach($article_categories as $categorie){
                $article_categorie = Article_categorie::where('categorie_id',$categorie->categories->id);
                $article_categorie_delete = $article_categorie->delete();
            }

             $medias=$Article->medias;
            foreach($medias as $media){
                $media_del = Media::find($media->id);
                $media_delete = $media_del->delete();
            }

            $commentaires=$Article->commentaires;
            foreach($commentaires as $commentaire){
                $commentaire_del = Commentaire::find($commentaire->id);
                $commentaire_delete = $commentaire_del->delete();
            }
            // $sell_lines=$sell->sell_lines;
            // foreach($sell_lines as $sell_line){
            //     $sell_line->delete();
            // }
            $Article->delete();

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

    public function accueilArticle(){
        $data=[];
        $reponses = Article::latest()->take(3)->get();
        foreach($reponses as $index=>$reponse){
            $data[$index]['id']=$reponse->id;
            $data[$index]['titre']=$reponse->titre;
            $data[$index]['slug']=$reponse->slug;
            $data[$index]['contenu']=$reponse->contenu;
            $data[$index]['created_at']=$reponse->created_at;
            $data[$index]['media']=$reponse->medias;
        }
        // $resp = Article::join('media','media.article_id','=','articles.id')->get();
        // return $data;
        return response()->json($data);
    }

    
    public function allArticle(){
        $data=[];
        $page = Page::first();
        $page_paginate= isset($page->nbre_article) ? $page->nbre_article : 10;
        $reponses = Article::paginate($page_paginate);
        foreach($reponses as $index=>$reponse){
            $data[$index]['id']=$reponse->id;
            $data[$index]['titre']=$reponse->titre;
            $data[$index]['slug']=$reponse->slug;
            $data[$index]['contenu']=$reponse->contenu;
            $data[$index]['created_at']=$reponse->created_at;
            $data[$index]['media']=$reponse->medias;
        }
         if(!empty($data)){
             $data['reponses']= $reponses;
            }
        // $resp = Article::join('media','media.article_id','=','articles.id')->get();
        // return $data;
        return response()->json($data);
    }

}

