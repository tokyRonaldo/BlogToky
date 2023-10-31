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

class MediaController extends Controller
{
    public function index(Request $request){
        // if ($request->ajax()) {
            $data = media::latest()->get();
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
                  
                    $html .= '<li><a @click="editerMedia" class="edit-media dropdown-item" id="editMedia-'.$row->id.'"><i class="fas fa-edit"></i>edit</a></li>';
                    $html .= '<li><a   @click="deleteMedia" id="deleteMedia-'.$row->id.'" class="delete-media dropdown-item"><i  class="fa fa-trash"></i>delete</a></li>';
                    // $html .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm">edit</a>';
                    $html .= '</ul></div>';
            //     }
            // }
            $html .= '</div>';
            return $html;
                })
              
                ->addColumn('alt', function($row){
                    $alt='<div class="alt">' .$row->alt.'</div>';
                    return $alt;
                })
                    ->addColumn('article', function($row){
                        $media_article=isset($row->articles->titre) ? $row->articles->titre : '';
                    $article='<div class="article">' .$media_article.'</div>';
                    return $article;
                })
                ->addColumn('file', function($row){
                    $img=$row->src;
                    $image=asset('/storage/images/'.$row->src);
                    // <img src="{{ asset('img/myimage.png') }}" alt="description of myimage">
                    return '<div style="display: flex;"><img src="' . $image . '" width="50px" height="50px" class="img-responsive"></div>';
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
               
                ->rawColumns(['action','article','alt','file','created_at','updated_at'])
                // ->rawColumns(['action','nom','prix'])
                ->make(true);
        // }

    }

    public function create(){
         $allArticle = Article::all();
      
         $result=[
                    'allArticle'=>$allArticle,
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
            $media_detail['alt']=$request->alt;
            $media_detail['article_id']=$request->article;

             //gerer l'insertion d'image ici
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $image = $request->file('file');
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
            $media_detail['src']=$fileNameToStore;

            $media = Media::create($media_detail);

           
           
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
        $media=Media::find($id);
        
        $allArticle = Article::all();
        $result=[
                'allArticle'=>$allArticle,
                'media'=>$media,
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
        $media=Media::find($id);
        
        // dd($request);
        try{

            $media_detail['alt']=$request->alt;
            $media_detail['article_id']=$request->article;

             //gerer l'insertion d'image ici
             if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $image = $request->file('file');
                $imageExtension = time() . '.' . $image->getClientOriginalExtension();
                $filenameWithExt = $image->getClientOriginalName ();
                // Get Filename
                $imageName = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Filename To store
                $fileNameToStore = $imageName. '_'. time().'.'.$imageExtension;
                
             $path = $image->storeAs('public/images', $fileNameToStore);  // C'est le répertoire de stockage relatif au de stockage Laravel (storage/app)
             
                if ($media->src) {
                    Storage::delete('public/images/' . $media->src);
                }
               $media_detail['src']=$fileNameToStore;
            // Enregistrez le chemin de l'image dans votre base de données ou faites ce que vous voulez
            }

            $media->update($media_detail);

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
            $media=Media::find($id);

            if ($media->src) {
                Storage::delete('public/images/' . $media->src);
              }

            $media->delete();

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

