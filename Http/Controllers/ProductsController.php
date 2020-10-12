<?php

namespace Modules\Products\Http\Controllers;

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

use Modules\Products\Models\Product;
use Modules\Categories\Models\Category;
use Modules\Brands\Models\Brand;

use Modules\Products\Http\Requests\ProductRequest;

class ProductsController extends Controller
{

    protected $menu_id;
    protected $menu_icon;
    protected $menu_name;
    protected $slug;
    protected $folder;
    protected $resize;
    protected $combine_filds;    
    
    public function __construct()
    {
        $slug = Functions::get_menuslug();
        $menu = Menu::where('slug',$slug)->first();
        $this->slug = $slug;        

        $this->folder = config('products.folder');
        $this->resize = config('products.resize');
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

    public function index(Request $request, Product $product)
    {  
        if( Gate::denies("manager_{$this->slug}") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $menu_id = $this->menu_id;
        $menu_icon = $this->menu_icon;
        $menu_name = $this->menu_name;
        $slug = $this->slug;
        $combine_filds = $this->combine_filds;

        if(!is_null($menu_id)){
            $products = $product->where('menu_id', $menu_id)->orderBy('id', 'desc')->paginate(50);
            return view('Product::index', compact('products', 'menu_icon', 'menu_name', 'slug', 'combine_filds'));
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
        $brands = new Brand;
        $categories_list = $categories->combo_all('',$menu_id);
        $brands_list = $option_void+$brands->combo();
        $status_list = Product::STATUS;
        $packing_list = $option_void+Product::PACKING;

        $categories_selected = null;
        
        return view('Product::create', 
            compact(
                'menu_id', 
                'menu_icon', 
                'menu_name', 
                'slug', 
                'combine_filds', 
                'categories_list', 
                'brands_list',
                'categories_selected',
                'status_list',
                'packing_list'
            )
        );
    }

    public function store(ProductRequest $request)
    {
        if(Gate::denies("manager_{$this->slug}") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');        

        $data = $request->only(array_keys($request->rules()));
        if(isset($request->media))
            $data['media'] = $this->_uploadImage($request);
        
        if(isset($request->file))
            $data['file'] = $this->_upload($request);
        
        if(isset($request->more_images))
            $data['more_images'] = $this->_uploadMultImage($request);

        $product = Product::create($data);

        $categories = $request->categories;
        if(!is_null($categories) && is_array($categories)){            
            $product->categories()->sync($categories);
        }
        return redirect()->back()->with('success','Adicionado com sucesso!');
    }

    public function edit(Product $product)
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
        $brands = new Brand;
        $categories_list = $categories->combo_all('',$menu_id);
        $status_list = Product::STATUS;
        $packing_list = $option_void+Product::PACKING;
        $brands_list = $option_void+$brands->combo();

        $categories_selected = $product->categories()->pluck('categories.id')->toArray();

        return view('Product::edit', 
            compact(
                'product', 
                'languages', 
                'menu_id', 
                'menu_icon', 
                'menu_name', 
                'slug', 
                'combine_filds', 
                'categories_list', 
                'categories_selected',
                'status_list',
                'brands_list',
                'packing_list'
            )
        );
    }

    public function update(ProductRequest $request, Product $product)
    {
        if( Gate::denies("manager_{$this->slug}") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $data = $request->only(array_keys($request->rules()));        

        if(isset($request->media))
            $data['media'] = $this->_uploadImage($request);
        
        if(isset($request->file))
            $data['file'] = $this->_upload($request);
           
        $images_restantes = !is_null($product->more_images) ? $product->more_images.',' : '';
        if(isset($request->image_remove) && !empty($request->image_remove) ){
            $images_restantes = $this->_removeImage($request->image_remove, $product->more_images );
        }

        if(isset($request->more_images))
            $data['more_images'] = $images_restantes.$this->_uploadMultImage($request);
        elseif(!isset($request->more_images) && $images_restantes!='')
            $data['more_images'] = $images_restantes;

        $product->fill($data);
        $product->save();

        $categories = $request->categories;
        if(is_array($categories)){
            $product->categories()->sync($categories);
        }else{
            $product->categories()->sync([]);
        }
        return redirect()->back()->with('success','Atualizado com sucesso');
    }

    public function destroy(Product $product)
    {
        if( Gate::denies("manager_{$this->slug}") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');
            
        Translation::where('parent_id', $product->id)->where('menu_id', $this->menu_id)->delete();
        $product->delete();              
        return redirect()->back()->with('success','Excluído com sucesso!');
    }

    public function status(Product $product)
    {
        $status = $product->status == 'active' ? 'inactive' : 'active';
        $product->status = $status;
        $product->save();
        return redirect()->back()->with('success','Status atualizado com sucesso');
    }
    
    protected function _uploadImage(Request $request, $nameUpload = null)
    {
        if(isset($request->media)){           
            $responseUpload = \Upload::imagePublic($request, 'media', $this->folder, $nameUpload);
            if($responseUpload->original['success']){
                return $responseUpload->original['file'];
            }
            return null;
        }else{
            return null;
        }
    }    

    protected function _upload(Request $request, $nameUpload = null)
    {
        if(isset($request->file)){           
            $responseUpload = \Upload::genericPublic($request, 'file', $this->folder, $nameUpload);
            if($responseUpload->original['success']){
                return $responseUpload->original['file'];
            }
            return null;
        }else{
            return null;
        }
    }

    protected function _uploadMultImage(Request $request)
    {
        if(isset($request->more_images)){
            $responseUpload = \Upload::imageMultPublic($request, 'more_images', $this->folder, $this->resize);
            if(count($responseUpload) > 0){
                return implode(',',$responseUpload);
            }
            return null;
        }else{
            return null;
        }
    }

    protected function _removeImage($image_remove, $more_images)
    {
        $image_removeArray = explode(',', $image_remove);
        $more_images = explode(',', $more_images);
        $diferenca = array_diff($more_images, $image_removeArray);
        if(count($diferenca) > 0){
            $retorno = implode(',',$diferenca);
            return $retorno.',';
        }else{
            return '';
        }
    }

}