<?php

namespace Modules\Posts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Gate;
use Auth;

use App\Helpers\Functions;
use App\Models\Menu;
use App\Models\Language;
use App\Models\Notification;
use App\Models\Translation;
use App\Models\Permission;

use Modules\Posts\Models\Post;
use Modules\Categories\Models\Category;
use Modules\Tags\Models\Tag;

use Modules\Posts\Http\Requests\PostRequest;

class PostsController extends Controller
{

    protected $menu_id;
    protected $menu_icon;
    protected $menu_name;
    protected $slug;
    protected $folder;
    protected $combine_filds;    
    
    public function __construct()
    {
        $slug = Functions::get_menuslug();
        $menu = Menu::where('slug',$slug)->first();
        $this->slug = $slug;        

        $this->folder = config('posts.folder');
        if($menu){
            $this->menu_id = is_null($menu->parent_id) ? $menu->id : $menu->parent_id;
            $this->menu_icon = $menu->icons;
            $this->menu_name = $menu->name;
            $keysFilds = explode(',',$menu->fields_active);
            $titlesFilds = explode(',',$menu->fields_title);
            $combineFilds = array_combine($keysFilds, $titlesFilds);
            $this->combine_filds = $combineFilds;
        }else{
            $this->menu_id = null;
        }
    }

    public function index(Request $request, Post $post)
    {  
        if( Gate::denies("manager_{$this->slug}") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $menu_id = $this->menu_id;
        $menu_icon = $this->menu_icon;
        $menu_name = $this->menu_name;
        $slug = $this->slug;
        $combine_filds = $this->combine_filds;

        if(!is_null($menu_id)){
            $posts = $post->where('menu_id', $menu_id)->orderBy('date_publish', 'desc')->paginate(50);
            return view('Post::index', compact('posts', 'menu_icon', 'menu_name', 'slug', 'combine_filds'));
        }else{
            abort(403, 'Página não encontrada');
        }
    }

    public function create()
    {
        if( Gate::denies("manager_{$this->slug}") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');        

        $menu_id = $this->menu_id;
        $menu_icon = $this->menu_icon;
        $menu_name = $this->menu_name;
        $slug = $this->slug;
        $combine_filds = $this->combine_filds;

        $option_void = ['' => 'Selecione' ];
        $categories = new Category;
        $categories_list = $categories->combo_all('',$menu_id);
        $tags_list = Tag::where('menu_id', $menu_id)->orderBy('name', 'asc')->get()->pluck('name', 'id')->all();
        $format_list = Post::FORMAT;
        $status_list = Post::STATUS;

        $categories_selected = null;
        $tags_selected = null;
        
        return view('Post::create', 
            compact(
                'menu_id', 
                'menu_icon', 
                'menu_name', 
                'slug', 
                'combine_filds', 
                'categories_list', 
                'tags_list', 
                'format_list',
                'categories_selected',
                'tags_selected',
                'status_list'
            )
        );
    }

    public function store(PostRequest $request)
    {
        if(Gate::denies("manager_{$this->slug}") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $data = $request->only(array_keys($request->rules()));
        if(isset($request->media))
            $data['media'] = $this->_upload($request);

        $data['user_id'] = $user_id = auth()->user()->id;

        $permission = Permission::where('name','moderator')->first();
        if(Auth::user()->hasPermission($permission)){
            $data['status'] = 'active';
        }else{
            $data['status'] = 'moderate';
        }

        $post = Post::create($data);

        $categories = $request->categories;
        if(is_array($categories)){
            $post->categories()->attach($categories);
        }
        $tags = $request->tags;
        if(is_array($tags)){
            $post->tags()->attach($tags);
        }

        if($post->status == 'moderate'){
            Notification::create(['name' => 'Um post requer moderação', 'description' => '<p> Um novo post foi adicionado e requer moderção, por favor acesse a pagina de posts para aprovar ou rejeitar a públicação. </p>', 'type' => 'info' ]);
        }

        return redirect()->back()->with('success','Adicionado com sucesso!');
    }

    public function edit(Post $post)
    {
        if( Gate::denies("manager_{$this->slug}") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $menu_id = $this->menu_id;
        $menu_icon = $this->menu_icon;
        $menu_name = $this->menu_name;
        $slug = $this->slug;
        $combine_filds = $this->combine_filds;
        $languages = Language::where('status', 'active')->orderBy('order', 'asc')->get();

        $option_void = ['' => 'Selecione' ];
        $categories = new Category;
        $categories_list = $categories->combo_all('',$menu_id);
        $tags_list = Tag::where('menu_id', $menu_id)->orderBy('name', 'asc')->get()->pluck('name', 'id')->all();
        $format_list = Post::FORMAT;
        $status_list = Post::STATUS;

        $categories_selected = $post->categories()->pluck('categories.id')->toArray();
        $tags_selected = $post->tags()->pluck('tags.id')->toArray();

        return view('Post::edit', 
            compact(
                'post', 
                'languages', 
                'menu_id', 
                'menu_icon', 
                'menu_name', 
                'slug', 
                'combine_filds', 
                'categories_list', 
                'tags_list', 
                'format_list',
                'categories_selected',
                'tags_selected',
                'status_list'
            )
        );
    }

    public function update(PostRequest $request, Post $post)
    {
        if( Gate::denies("manager_{$this->slug}") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $data = $request->only(array_keys($request->rules()));
        if(isset($request->media))
            $data['media'] = $this->_upload($request, $post->media);

        $post->fill($data);
        $post->save();

        $categories = $request->categories;
        if(is_array($categories)){
            $post->categories()->sync($categories);
        }
        $tags = $request->tags;
        if(is_array($tags)){
            $post->tags()->sync($tags);
        }
        return redirect()->back()->with('success','Atualizado com sucesso');
    }

    public function destroy(Post $post)
    {
        if( Gate::denies("manager_{$this->slug}") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');
            
        Translation::where('parent_id', $post->id)->where('menu_id', $this->menu_id)->delete();
        $post->delete();              
        return redirect()->back()->with('success','Excluído com sucesso!');
    }

    public function status(Post $post)
    {
        $status = $post->status == 'active' ? 'inactive' : 'active';
        $post->status = $status;
        $post->save();
        return redirect()->back()->with('success','Status atualizado com sucesso');
    }

    public function user(Request $request, Post $post)
    {
        if(isset($request->user_id) && is_numeric($request->user_id) ){
            $post->user_id = (int)$request->user_id;
            $post->save();
            return redirect()->back()->with('success','Autor atualizado com sucesso');
        }else{
            return redirect()->back()->with('error','Não foi possível atualizar o Autor');
        }
    }

    

    protected function _upload(Request $request, $nameUpload = null)
    {
        if(isset($request->media)){           
            $responseUpload = \Upload::genericPublic($request, 'media', $this->folder, $nameUpload);
            if($responseUpload->original['success']){
                return $responseUpload->original['file'];
            }
            return null;
        }else{
            return null;
        }
    }

}