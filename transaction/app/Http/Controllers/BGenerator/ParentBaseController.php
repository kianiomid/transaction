<?php namespace App\Http\Controllers\BGenerator;

use Illuminate\Container\Container as Application;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Exception;
use Illuminate\Support\Facades\Schema;
use Prettus\Repository\Criteria\RequestCriteria;
use Session;
use Request;
use Config;
use File;
use Input;
use Auth;
use DB;

class ParentBaseController extends BaseController {

    protected $skeleton = 'admin_generator_parent';

    /* PARENT GENERATOR */
    protected $parentModel;
    protected $parentRelatedKey;
    protected $childForeignKey;
    protected $parentObject;
    protected $parentModelName;

    const NS_PARENT_MODEL = 'parentModel';
    const NS_PARENT_RELATED_KEY = 'parentRelatedKey';
    const NS_CHILD_FOREIGN_KEY = 'childForeignKey';

    protected function processParams($json_config)
    {

        parent::processParams($json_config);

        if(!isset($json_config[self::NS_PARAMS][self::NS_PARENT_MODEL])){
            throw new \Exception("AG Configuration: Parent Model Not Defined.");
        }else{
            $this->parentModel = $json_config[self::NS_PARAMS][self::NS_PARENT_MODEL];
        }

        if(!isset($json_config[self::NS_PARAMS][self::NS_PARENT_RELATED_KEY])){
            throw new \Exception("AG Configuration: Parent Related Key Not Defined.");
        }else{
            $this->parentRelatedKey = $json_config[self::NS_PARAMS][self::NS_PARENT_RELATED_KEY];
        }

        $this->childForeignKey = 'id';
        if(isset($json_config[self::NS_PARAMS][self::NS_CHILD_FOREIGN_KEY])){
            $this->childForeignKey = $json_config[self::NS_PARAMS][self::NS_CHILD_FOREIGN_KEY];
        }

        $model_explode = explode("\\", $this->parentModel);
        $this->parentModelName = array_last($model_explode);

    }

    protected function inflateParent($pid = null){

        $this->parentObject = call_user_func_array($this->parentModel . '::find', array(
            $pid
        ));

        if(!$this->parentObject){
            throw new \Exception("AG: Parent Object Does not exist.");
        }

    }

    protected $defaultListActions = [
        'create' => [
            'route' => 'create',
            'class' => 'btn btn-primary',
            'label' => 'generator.add_new'
        ],
        'back' => [
            'route' => 'back',
            'class' => 'btn btn-warning',
            'label' => 'generator.back_to_parent'
        ]
    ];


}