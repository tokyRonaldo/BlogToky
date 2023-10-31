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
use Illuminate\Support\Facades\Storage;


use DataTables;

class PageController extends Controller
{
    public function index(Request $request){
        // if ($request->ajax()) {
            $data = Page::latest()->get();
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
                  
                    $html .= '<li><a @click="editerPage" class="edit-page dropdown-item" id="editPage-'.$row->id.'"><i class="fas fa-edit"></i>edit</a></li>';
                    $html .= '<li><a   @click="deletePage" id="deletePage-'.$row->id.'" class="delete-page dropdown-item"><i  class="fa fa-trash"></i>delete</a></li>';
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
                ->addColumn('description', function($row){
                    $description='<div class="description">' .$row->description.'</div>';
                    return $description;
                })
                // ->addColumn('sku', function($row){
                //     $sku='<span>' .$row->sku.'</span>';
                //     return $sku;
                // })
                ->addColumn('nbre_article', function($row){
                    $nbre_article='<div class="nbre_article">' .$row->nbre_article.'</div>';
                    return $nbre_article;
                })
                    ->addColumn('apropos', function($row){
                        $apropos_user=$row->users->name;
                    $apropos='<div class="apropos">' .$apropos_user.'</div>';
                    return $apropos;
                })
                ->addColumn('logo', function($row){
                    $img=$row->logo;
                    $image=asset('/storage/images/'.$row->logo);  //asset mi acceder ny ao amn app/public
                    
                    // <img src="{{ asset('img/myimage.png') }}" alt="description of myimage">
                    return '<div style="display: flex;"><img src="' . $image . '" width="50px" height="50px" class="img-responsive"></div>';
                //   return $img;
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
               
                ->rawColumns(['action','titre','description','apropos','nbre_article','logo','created_at','updated_at'])
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
       
        try{
            $page_detail['titre']=$request->titre;
            $page_detail['description']=$request->description;
            $page_detail['apropos_user']=$request->apropos;
            $page_detail['nbre_article']=$request->nbre_article;

            //gerer l'insertion d'image ici
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $image = $request->file('logo');
                $imageExtension = time() . '.' . $image->getClientOriginalExtension();
                $filenameWithExt = $image->getClientOriginalName ();
                // Get Filename
                $imageName = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Filename To store
                $fileNameToStore = $imageName. '_'. time().'.'.$imageExtension;
                
             $path = $image->storeAs('public/images', $fileNameToStore);  // C'est le répertoire de stockage relatif au de stockage Laravel (storage/app)
    
            // Enregistrez le chemin de l'image dans votre base de données ou faites ce que vous voulez
            }
             // Else add a dummy image
             else {
                $fileNameToStore = 'noimage.jpg';
                }
            // $logo=$request->logo;
            $page_detail['logo']=$fileNameToStore;

            $page = Page::create($page_detail);

           
           
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
        $page=Page::find($id);
        
        $allUser = User::all();
        $result=[
                'page'=>$page,
                'allUser'=>$allUser,
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
        $page=Page::find($id);
        
        // dd($request);
        try{

            $page_detail['titre']=$request->titre;
            $page_detail['description']=$request->description;
            $page_detail['apropos_user']=$request->apropos;
            $page_detail['nbre_article']=$request->nbre_article;

            //gerer l'insertion d'image ici
             //gerer l'insertion d'image ici
             if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $image = $request->file('logo');
                $imageExtension = time() . '.' . $image->getClientOriginalExtension();
                $filenameWithExt = $image->getClientOriginalName ();
                // Get Filename
                $imageName = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Filename To store
                $fileNameToStore = $imageName. '_'. time().'.'.$imageExtension;
                
             $path = $image->storeAs('public/images', $fileNameToStore);  // C'est le répertoire de stockage relatif au de stockage Laravel (storage/app)
             
             if ($page->logo) {
                Storage::delete('public/images/' . $page->logo);
              }

             $page_detail['logo']=$fileNameToStore;
            // Enregistrez le chemin de l'image dans votre base de données ou faites ce que vous voulez
            }
         
            

            $page->update($page_detail);

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
            $page=Page::find($id);
            if ($page->logo) {
                Storage::delete('public/images/' . $page->logo);
              }

            $page->delete();

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

    public function accueilApropos(){
        $page = Page::first();
        $apropos=isset($page->users) ? $page->users : null;
        $result=[
            'page'=>$page,
            'apropos'=>$apropos,
            ];
        // return $data;
        return response()->json($result);
    }
    
    public function checkPage(){
        $page = Page::all();
        $result=[
            'page'=>$page,
            ];
        // return $data;
        return response()->json($result);
    }
    
}

