<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Media;
use App\Models\Categorie;
use App\Models\Article_categorie;
use App\Models\Commentaire;
use App\Models\User;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

use DataTables;

class CategorieController extends Controller
{
    public function index(Request $request){
        // if ($request->ajax()) {
            $data = Categorie::latest()->get();
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
                  
                    $html .= '<li><a @click="editerCategorie" class="edit-categorie dropdown-item" id="editCategorie-'.$row->id.'"><i class="fas fa-edit"></i>edit</a></li>';
                    $html .= '<li><a   @click="deleteCategorie" id="deleteCategorie-'.$row->id.'" class="delete-categorie dropdown-item"><i  class="fa fa-trash"></i>delete</a></li>';
                    // $html .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm">edit</a>';
                    $html .= '</ul></div>';
            //     }
            // }
            $html .= '</div>';
            return $html;
                })
                ->addColumn('nom', function($row){
                    $nom='<div class="nom">' .$row->nom.'</div>';
                    return $nom;
                })
                ->addColumn('slug', function($row){
                    $slug='<div class="slug">' .$row->slug.'</div>';
                    return $slug;
                })
                ->addColumn('couleur', function($row){
                    $couleur='<div class="couleur">' .$row->couleur.'</div>';
                    return $couleur;
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
               
                ->rawColumns(['action','nom','slug','couleur','created_at','updated_at'])
                // ->rawColumns(['action','nom','prix'])
                ->make(true);
        // }

      
        
    }

    public function create(){
        $allCategorie=Categorie::all();
         $result=[
                    'allCategorie'=>$allCategorie,
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
            $categorie_detail['nom']=$request->nom;
            $categorie_detail['couleur']=$request->couleur;

            $slug = generateSlug($request->nom);
            $categorie_detail['slug']=$slug;

            $categorie = Categorie::create($categorie_detail);
           
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
    
           $categorie=Categorie::findOrFail($id);
  
           $result=[
            'categorie'=>$categorie,
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
        $categorie=Categorie::find($id);
        
        $result=[
            'categorie'=>$categorie,
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
        $categorie=Categorie::find($id);
        
        // dd($request);
        try{
          
            $categorie_detail['nom']=$request->nom;
            
            $categorie_detail['couleur']=$request->couleur;

            $slug = generateSlug($request->nom);
            $categorie_detail['slug']=$slug;

            $categorie->update($categorie_detail);

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
            $categorie=Categorie::find($id);

            $categorie->delete();

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

    public function accueilCategorie(){
        $data = Categorie::all();
        return response()->json($data);
    }

    public function articleCategorie($id){
        $data=[];
        $page = Page::first();
        $page_paginate= isset($page->nbre_article) ? $page->nbre_article : 10;
        // $reponses = Article::paginate($page_paginate);
        $reponses = Article::whereHas('article_categories', function ($query) use ($id) {
                        $query->whereHas('categories', function ($query) use ($id) {
                                    $query->where('categories.id', '=', $id );
                                });
                    })->paginate($page_paginate);
        
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

        return response()->json($data);
    }
}
