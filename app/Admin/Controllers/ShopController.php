<?php

namespace App\Admin\Controllers;

use App\Models\Shop;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Extensions\Tools\CsvImport;
 use Goodby\CSV\Import\Standard\Lexer;
 use Goodby\CSV\Import\Standard\Interpreter;
 use Goodby\CSV\Import\Standard\LexerConfig;
 use Illuminate\Http\Request;

class ShopController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Shop';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Shop());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('description', __('Description'));
        $grid->column('price', __('Price'))->sortable();
        $grid->column('category.name', __('Category Name'));
         $grid->column('image', __('Image'))->image();
         $grid->column('recommend_flag', __('Recommend Flag'));
         $grid->column('created_at', __('Created at'))->sortable();
         $grid->column('updated_at', __('Updated at'))->sortable();
        
         $grid->filter(function($filter) {
            $filter->like('name', '商品名');
            $filter->like('description', '商品説明');
            $filter->between('price', '金額');
            $filter->in('category_id', 'カテゴリー')->multipleSelect(Category::all()->pluck('name', 'id'));
            $filter->equal('recommend_flag', 'おすすめフラグ')->select(['0' => 'false', '1' => 'true']);
        });

        $grid->tools(function ($tools) {
            $tools->append(new CsvImport());
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Shop::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('price', __('Price'));
        $show->field('category.name', __('Category Name'));
         $show->field('image', __('Image'))->image();
         $show->field('recommend_flag', __('Recommend Flag'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Shop());

        $form->text('name', __('Name'));
        $form->textarea('description', __('Description'));
        $form->number('price', __('Price'));
        $form->select('category_id', __('Category Name'))->options(Category::all()->pluck('name', 'id'));
        $form->image('image', __('Image'));
        $form->switch('recommend_flag', __('Recommend Flag'));

        return $form;
    }

    public function csvImport(Request $request)
     {
         $file = $request->file('file');
         $lexer_config = new LexerConfig();
         $lexer = new Lexer($lexer_config);
 
         $interpreter = new Interpreter();
         $interpreter->unstrict();
 
         $rows = array();
         $interpreter->addObserver(function (array $row) use (&$rows) {
             $rows[] = $row;
         });
 
         $lexer->parse($file, $interpreter);
         foreach ($rows as $key => $value) {
 
             if (count($value) == 7) {
                 Shop::create([
                     'name' => $value[0],
                     'description' => $value[1],
                     'price' => $value[2],
                     'category_id' => $value[3],
                     'image' => $value[4],
                     'recommend_flag' => $value[5],
                     
                 ]);
             }
         }
 
         return response()->json(
             ['data' => '成功'],
             200,
             [],
             JSON_UNESCAPED_UNICODE
         );
     }

     
}
