<?php namespace App\Http\Controllers\BGenerator;

use App\Http\Controllers\Controller;
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
use Route;
use App;

class BaseController extends Controller {

    public $title;
    public $lang;
    public $query;
    public $list;
    public $expand;
    public $view = 'admin';
    protected $endTime = 0;
    protected $loadTime = 0;
    protected $startTime = 0;
    public $adminStatus = 'offline';

    protected $skeleton = 'admin_generator';
    protected $params = [];
    protected $fields;
    protected $fieldSets = [];
    protected $model;
    protected $repository;
    protected $entityManager = null;
    protected $modelName;
    protected $listTitle;
    protected $listItems;
    protected $listSort = null;
    protected $perPage = 20;
    protected $listQuery = null;

    protected $excelItems;

    protected $newTitle;
    protected $newItems;

    protected $editTitle;
    protected $editItems;

    protected $showTitle;
    protected $showItems;

    protected $filterItems;
    protected $filterSession;

    protected $objectActions;
    protected $listActions;
    protected $createActions;
    protected $editActions;
    protected $batchActions;
    protected $generalActions;
    protected $showActions;

    protected $sortField = null;
    protected $sortOrder = null;


    const DEFAULT_REPOSITORIES_NAMESPACE = 'App\\Repositories\\';
    const DEFAULT_REPOSITORIES_POSTFIX = 'Repository';
    const DEFAULT_REPOSITORY_INSTANCE_METHOD = 'getInstance';

    const DEFAULT_FILLABLE = true;
    const DEFAULT_SEARCHABLE = true;
    const DEFAULT_SORTABLE = false;
    const DEFAULT_PRIMARY = false;
    const DEFAULT_IN_INDEX = false;
    const DEFAULT_IN_FORM = false;
    const DEFAULT_ICON = 'glyphicon glyphicon-edit';
    const CUSTOM_VIEWS_ROOT = 'backoffice';
    const CUSTOM_VIEWS_API_ROOT = 'api';

    const NS_PARAMS = 'params';
    const NS_CUSTOM_VIEW = 'customView';
    const NS_SKELETON = 'skeleton';
    const NS_MODEL = 'model';
    const NS_REPOSITORY = 'repository';
    const NS_ENTITY_MANAGER = 'entityManager';
    const NS_THEME = 'theme';
    const NS_PARENT_CLASS = 'parent_class';
    const NS_PARENT_REF = 'parentRef';
    const NS_OBJECT_REF = 'objectRef';
    const NS_FIELDS = 'fields';
    const NS_FIELDSETS = 'fieldsets';
    const NS_LIST = 'list';
    const NS_EXCEL = 'excel';
    const NS_FORM = 'form';
    const NS_FILTER = 'filter';
    const NS_EDIT = 'edit';
    const NS_NEW = 'new';
    const NS_ACTIONS = 'actions';
    const NS_OBJECT_ACTIONS = 'objectActions';
    const NS_BATCH_ACTIONS = 'batchActions';
    const NS_GENERAL_ACTIONS = 'generalActions';
    const NS_DISPLAY = 'display';
    const NS_COUNT_PER_PAGE = 'countPerPage';
    const NS_QUERY = 'query';
    const NS_SORT = 'sort';

    const NS_IN_FORM = 'inForm';
    const NS_IN_INDEX = 'inIndex';
    const NS_SOTRABLE = 'sortable';
    const NS_SEARCHABLE = 'searchable';
    const NS_FILLABLE = 'fillable';
    const NS_PRIMARY = 'primary';
    const NS_DB_TYPE = 'dbType';
    const NS_NAME = 'name';
    const NS_LABEL = 'label';
    const NS_HELPER = 'helper';
    const NS_PLACEHOLDER = 'placeholder';
    const NS_DEFAULT_VALUE = 'defaultValue';
    const NS_TYPE = 'type';
    const NS_VALIDATION = 'validation';
    const NS_DATA_PROVIDER = 'dataProvider';
    const NS_MASK = 'mask';
    const NS_CLASS = 'class';
    const NS_CHOICES = 'choices';
    const NS_EXPANDED = 'expanded';
    const NS_MULTIPLE = 'multiple';
    const NS_SESSION_PREFIX = 'sessionPrefix';

    const NS_TITLE = 'title';
    const NS_SHOW = 'show';

    const NS_ROUTE = 'route';
    const NS_VALUE = 'value';
    const NS_ICON = 'icon';
    const NS_CONFIRM = 'confirm';
    const NS_METHOD = 'method';
    const NS_CONDITION = 'condition';

    const DB_TYPE_INT = 'int';
    const DB_TYPE_TEXT = 'text';
    const DB_TYPE_DATE = 'date';

    const BUTTON_TYPE_LINK = 'link';
    const BUTTON_TYPE_SUBMIT = 'submit';
    const BUTTON_TYPE_REACT = 'react';
    const BUTTON_TYPE_ACTION = 'action';
    const BUTTON_TYPE_MODAL = 'modal';

    const VIEW_MODE_NO_API = 'noApi';
    const VIEW_MODE_API = 'api';

    const NS_VIEW = 'view';

    public static $filterGenderConvert = [
        '' => '',
        'm' => 'مرد',
        'f' => 'زن'
    ];

    public function __construct($configFile)
    {
        // get configuration
        $this->processConfigFile($configFile);

    }

    protected function getRequestParameters($items){

        $input = request()->all();

        foreach($items as $item){

            if(is_array($item)){

                foreach($item as $it){

                    if(!isset($input[$it])){
                        $input[$it] = null;
                    }

                }

            }else{

                if(!isset($input[$item])){
                    $input[$item] = null;
                }

            }


        }

        return $input;

    }

    protected function fillFormRelations($formItems, $item = null, $parentItem = null){

        foreach($formItems as $formFieldSet){
            foreach($formFieldSet as $fieldName){
                $field = $this->fields[$fieldName];
                if(isset($field[self::NS_FORM])){
                    $form = $field[self::NS_FORM];
                    if(isset($form[self::NS_DATA_PROVIDER])){
                        $dataProvider = $form[self::NS_DATA_PROVIDER];
                        $validation = $form[self::NS_VALIDATION];
                        $multiple = isset($form[self::NS_MULTIPLE]) ? $form[self::NS_MULTIPLE] : false;
                        $isRequired = array_search('required', $validation) !== false;
                        $model = isset($form[self::NS_MODEL]) ? $form[self::NS_MODEL] : null;
                        $method = isset($form[self::NS_METHOD]) ? $form[self::NS_METHOD] : null;

                        if($multiple == false && $isRequired == false && isset($form[self::NS_PLACEHOLDER])){
                            $isRequired = $form[self::NS_PLACEHOLDER];
                        }

                        $res = $this->loadFormFilterRelationFromDB($dataProvider, $fieldName, $model, $method, $isRequired, $item, $parentItem);
                        $this->fields[$fieldName][self::NS_FORM][self::NS_CHOICES] = $res;
                    }
                }
            }
        }

    }

    protected function fillFilterRelations($formItems, $parentItem = null){
        foreach($formItems as $fieldName){
            $field = $this->fields[$fieldName];
            if(isset($field[self::NS_FILTER])){
                $form = $field[self::NS_FILTER];
                if(isset($form[self::NS_DATA_PROVIDER])){
                    $dataProvider = $form[self::NS_DATA_PROVIDER];
                    $validation = $form[self::NS_VALIDATION];
                    $multiple = isset($form[self::NS_MULTIPLE]) ? $form[self::NS_MULTIPLE] : false;
                    $isRequired = array_search('required', $validation) !== false;
                    $model = isset($form[self::NS_MODEL]) ? $form[self::NS_MODEL] : null;
                    $method = isset($form[self::NS_METHOD]) ? $form[self::NS_METHOD] : null;

                    if($multiple == false && $isRequired == false && isset($form[self::NS_PLACEHOLDER])){
                        $isRequired = $form[self::NS_PLACEHOLDER];
                    }

                    $res = $this->loadFormFilterRelationFromDB($dataProvider, $fieldName, $model, $method, $isRequired, null, $parentItem);
                    $this->fields[$fieldName][self::NS_FILTER][self::NS_CHOICES] = $res;
                }
            }
        }
    }

    protected function loadFormFilterRelationFromDB($dataProvider, $fieldName, $model = null, $method = null, $isRequired = false, $item = null, $parentItem = null){

        if(method_exists($this->repository, $dataProvider)) {

            $choices = $this->repository->{$dataProvider}($item, $parentItem);
            $res = [];

            if (!is_bool($isRequired)) {
                $res[''] = __($isRequired);
            }else{

                if($isRequired == false){
                    $res[''] = "";
                }

            }

            foreach ($choices as $choice) {
                $res[$choice->getKey()] = $choice->__toString();
            }

            return $res;

        }elseif(Route::has($dataProvider)){

            if($method == null){
                $method = '__toString';
            }

            $res = [];

            $session = request()->session()->get($this->filterSession);

            If(request()->has($fieldName)) {

                $choice = call_user_func_array($model . "::find" , [
                    request()->get($fieldName)
                ]);

                if($choice != null) {
                    $res[$choice->getKey()] = $choice->{$method}();
                }

            }elseif($item != null){

                $choice = call_user_func_array($model . "::find", [
                    $item->{$fieldName}
                ]);

                if($choice != null){
                    $res[$choice->getKey()] = $choice->{$method}();
                }

            }elseif(isset($session['searchFilter'][$fieldName])){

                $choice = call_user_func_array($model . "::find", [
                    $session['searchFilter'][$fieldName]
                ]);

                if($choice != null) {
                    $res[$choice->getKey()] = $choice->{$method}();
                }

            }

            return $res;

        }else{
            throw new \Exception("AG Configuration: Data Provider Method Not Exists: " . get_class($this->repository) . '::' . $dataProvider);
        }

    }

    protected function prepareCustomFormValidation($fields, $item = null, $parentItem = null){
        $formItems = [];
        $formItems[] = array_keys($fields);
        return $this->prepareFormValidation($fields, $formItems, $item, $parentItem);
    }

    protected function prepareFormValidation($fields, $formItems, $item = null, $parentItem = null)
    {

        $validationResult = [];

        foreach ($formItems as $formFieldSet) {

            foreach ($formFieldSet as $fieldName) {
                $field = $fields[$fieldName];
                if (isset($field[self::NS_FORM])) {
                    $form = $field[self::NS_FORM];
                    $validationArray = isset($form[self::NS_VALIDATION]) ? $form[self::NS_VALIDATION] : ['nullable'];

                    if(is_array($validationArray)){
                        foreach($validationArray as $xKey => $x){
                            $isUnique = strpos($x, 'unique') !== false;
                            if($isUnique && $item !== null) {
                                $validationArray[$xKey] = $x . ',' . $item->getKey();
                            }
                        }
                    }

                    if (isset($form[self::NS_DATA_PROVIDER])) {
                        $dataProvider = $form[self::NS_DATA_PROVIDER];
                        $multiple = isset($form[self::NS_MULTIPLE]) ? $form[self::NS_MULTIPLE] : false;
                        $model = isset($form[self::NS_MODEL]) ? $form[self::NS_MODEL] : null;
                        $method = isset($form[self::NS_METHOD]) ? $form[self::NS_METHOD] : null;

                        $res = $this->loadFormFilterRelationFromDB($dataProvider, $fieldName, $model, $method, false, $item, $parentItem);

                        if($model == null){

                            $_in = array_keys($res);

                            $isRequired = array_search('required', $validationArray) !== false;
                            if(!$isRequired){
                                $_in[] = "";
                            }

                            $validationArray[] = 'in:'. join($_in, ',');

                        }else{
                            $modelObj = App::make($model);
                            $validationArray[] = 'exists:'.$modelObj->getTable().','.$modelObj->getKeyName();
                        }

                        if($multiple == true){
                            $validationArray[] = "array";
                        }
                    }

                    //$validationResult[$fieldName] = join($validationArray, '|');
                    $validationResult[$fieldName] = $validationArray;
                }
            }
        }

        return $validationResult;

    }

    protected function prepareFilterValidation($formItems, $parentItem = null){

        $validationResult = [];

        foreach($formItems as $fieldName){

            $field = $this->fields[$fieldName];
            if(isset($field[self::NS_FILTER])){
                $form = $field[self::NS_FILTER];
                $validationArray = $form[self::NS_VALIDATION];

                if(isset($form[self::NS_DATA_PROVIDER])){
                    $dataProvider = $form[self::NS_DATA_PROVIDER];
                    $model = isset($form[self::NS_MODEL]) ? $form[self::NS_MODEL] : null;
                    $method = isset($form[self::NS_METHOD]) ? $form[self::NS_METHOD] : null;

                    $res = $this->loadFormFilterRelationFromDB($dataProvider, $fieldName, $model, $method, false, null, $parentItem);

                    if($model == null){

                        $_in = array_keys($res);

                        $isRequired = array_search('required', $validationArray) !== false;
                        if(!$isRequired){
                            $_in[] = "";
                        }

                        $validationArray[] = 'in:'. join($_in, ',');

                    }else{
                        $modelObj = App::make($model);
                        $validationArray[] = 'exists:'.$modelObj->getTable().','.$modelObj->getKeyName();
                    }
                }

                //$validationResult[$fieldName] = join($validationArray, '|');
                $validationResult[$fieldName] = $validationArray;
            }

        }

        return $validationResult;

    }

    protected function prepareListSort($sortFieldRequestParam = null, $sortOrderRequestParam = null){

        if($sortFieldRequestParam != null){

            $this->sortField = $sortFieldRequestParam;

            if($sortOrderRequestParam == null || strtolower($sortOrderRequestParam) == 'asc'){
                $this->sortOrder = 'asc';
            }else{
                $this->sortOrder = 'desc';
            }

        }else{

            if(is_array($this->listSort)){
                $this->sortField = $this->listSort[0];
                $this->sortOrder = $this->listSort[1];
            }

        }

        if($this->sortField != null && $this->sortOrder != null){
            $this->repository->orderBy($this->sortField, $this->sortOrder);
        }

    }

    protected function processConfigFile($configFile){

        $path = resource_path('/generators/'.$configFile.'.json');
        $config = file_get_contents($path);

        try{

            $json_config = json_decode($config, true);

            $this->processParams($json_config);

            if(!isset($json_config[self::NS_FIELDS])){
                $json_config[self::NS_FIELDS] = [];
            }

            // instantiate columns
            $this->parseTableFields($json_config[self::NS_FIELDS]);

            if(!isset($json_config[self::NS_FIELDSETS])){
                $json_config[self::NS_FIELDSETS] = [];
            }

            // instantiate columns
            $this->parseTableFieldSets($json_config[self::NS_FIELDSETS]);

            if(!isset($json_config[self::NS_LIST])){
                $json_config[self::NS_LIST] = [];
            }

            $this->parseListItems($json_config[self::NS_LIST]);

            if(!isset($json_config[self::NS_EXCEL])){
                $json_config[self::NS_EXCEL] = [];
            }

            $this->parseExcelItems($json_config[self::NS_EXCEL]);

            $this->editItems = [];
            $this->newItems = [];
            $this->showItems = [];
            $this->filterItems = [];

            if(!isset($json_config[self::NS_FORM])){
                $json_config[self::NS_FORM] = [];
            }

            if(!isset($json_config[self::NS_NEW])){
                $json_config[self::NS_NEW] = [];
            }

            if(!isset($json_config[self::NS_EDIT])){
                $json_config[self::NS_EDIT] = [];
            }

            if(!isset($json_config[self::NS_SHOW])){
                $json_config[self::NS_SHOW] = [];
            }

            if(!isset($json_config[self::NS_FILTER])){
                $json_config[self::NS_FILTER] = [];
            }

            $this->parseFormItems($json_config[self::NS_FORM], $this->newItems);
            $this->parseFormItems($json_config[self::NS_FORM], $this->editItems);
            $this->parseFormItems($json_config[self::NS_FORM], $this->showItems, false);

            $this->parseNewItems($json_config[self::NS_NEW]);
            $this->parseFormItems($json_config[self::NS_NEW], $this->newItems);

            $this->parseEditItems($json_config[self::NS_EDIT]);
            $this->parseFormItems($json_config[self::NS_EDIT], $this->editItems);

            $this->parseShowItems($json_config[self::NS_SHOW]);
            $this->parseFormItems($json_config[self::NS_SHOW], $this->showItems, false);

            $this->parseFilterItems($json_config[self::NS_FILTER]);

        }catch (Exception $e){
            throw $e;
        }

    }

    protected function processParams($json_config)
    {

        if (isset($json_config[self::NS_PARAMS])) {
            $this->params = $json_config[self::NS_PARAMS];
        }

        if (!isset($this->params[self::NS_MODEL]) || $this->params[self::NS_MODEL] == '') {
            throw new \Exception("AG Configuration: Model Not Defined.");
        }

        // get skeleton
        if (isset($this->params[self::NS_SKELETON])) {
            $this->skeleton = $this->params[self::NS_SKELETON];
        }

        // get model
        $this->model = new $this->params[self::NS_MODEL];

        if(!$this->model){
            throw new \Exception("AG Configuration: Model Cannot be instanciated.");
        }


        $model_explode = explode("\\", $this->params[self::NS_MODEL]);
        $this->modelName = array_last($model_explode);

        // custom views folder
        if(!isset($this->params[self::NS_CUSTOM_VIEW])){
            $this->params[self::NS_CUSTOM_VIEW] = self::CUSTOM_VIEWS_ROOT . '.' . $this->modelName;
        }

        // get repository
        if(isset($this->params[self::NS_REPOSITORY])){
            $repository = $this->params[self::NS_REPOSITORY];
        }else{
            $repository = self::DEFAULT_REPOSITORIES_NAMESPACE . $this->modelName . self::DEFAULT_REPOSITORIES_POSTFIX;
        }

        if(isset($this->params[self::NS_ENTITY_MANAGER])){
            $this->entityManager = $this->params[self::NS_ENTITY_MANAGER];
        }

        try {
            $this->repository = call_user_func_array($repository . '::' . self::DEFAULT_REPOSITORY_INSTANCE_METHOD, array(
                app(),
                $this->model,
                $this->entityManager
            ));

        } catch (\ErrorException $e) {
            throw new \Exception("AG Configuration: Cannot Instantiate Repository: " . $repository . '::' . self::DEFAULT_REPOSITORY_INSTANCE_METHOD);
        }

    }

    protected function parseTableFields($json_config_fields)
    {

        $columns = Schema::getColumnListing($this->model->getTable());
        $columnStructures = DB::select(DB::raw('SHOW FIELDS FROM ' . $this->model->getTable()));

        foreach($columns as $column){

            $this->fields[$column] = [];
            $this->fields[$column][self::NS_LABEL] = __($column);
            $this->fields[$column][self::NS_IN_INDEX] = true;
            $this->fields[$column][self::NS_IN_FORM] = true;
            $this->fields[$column][self::NS_SOTRABLE] = true;

            if($column == 'id'){
                $this->fields[$column][self::NS_PRIMARY] = true;
            }

            if($column == 'created_at' || $column == 'updated_at' || $column == 'deleted_at' || $column == 'id'){
                $this->fields[$column][self::NS_FILLABLE] = false;
                $this->fields[$column][self::NS_IN_FORM] = false;
            }

            // fill form and filter
            $this->buildFieldFormStructure($column, $columnStructures);

        }

        if(is_array($json_config_fields)){

            foreach($json_config_fields as $field){

                if(!isset($this->fields[$field[self::NS_NAME]])){
                    $this->fields[$field[self::NS_NAME]] = [];
                    $this->fields[$field[self::NS_NAME]][self::NS_SEARCHABLE] = false;
                    $this->fields[$field[self::NS_NAME]][self::NS_FILLABLE] = false;
                }

                if(isset($field[self::NS_LABEL])){
                    $this->fields[$field[self::NS_NAME]][self::NS_LABEL] = __($field[self::NS_LABEL]);
                }

                if(isset($field[self::NS_SOTRABLE])){
                    $this->fields[$field[self::NS_NAME]][self::NS_SOTRABLE] = $field[self::NS_SOTRABLE];
                }else{
                    if(!isset($this->fields[$field[self::NS_NAME]][self::NS_SOTRABLE])){
                        $this->fields[$field[self::NS_NAME]][self::NS_SOTRABLE] = self::DEFAULT_SORTABLE;
                    }
                }

                if(isset($field[self::NS_SEARCHABLE])){
                    $this->fields[$field[self::NS_NAME]][self::NS_SEARCHABLE] = $field[self::NS_SEARCHABLE];
                }

                if(isset($field[self::NS_FILLABLE])){
                    $this->fields[$field[self::NS_NAME]][self::NS_FILLABLE] = $field[self::NS_FILLABLE];
                }

                if(isset($field[self::NS_PRIMARY])){
                    $this->fields[$field[self::NS_NAME]][self::NS_PRIMARY] = $field[self::NS_PRIMARY];
                }

                if(isset($field[self::NS_IN_INDEX])){
                    $this->fields[$field[self::NS_NAME]][self::NS_IN_INDEX] = $field[self::NS_IN_INDEX];
                }

                if(isset($field[self::NS_IN_FORM])){
                    $this->fields[$field[self::NS_NAME]][self::NS_IN_FORM] = $field[self::NS_IN_FORM];
                }

                if(isset($field[self::NS_DB_TYPE])){
                    $this->fields[$field[self::NS_NAME]][self::NS_DB_TYPE] = $field[self::NS_DB_TYPE];
                }

                if(isset($field[self::NS_FORM])){
                   if(isset($field[self::NS_FORM][self::NS_CLASS])){
                       $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_CLASS] = $field[self::NS_FORM][self::NS_CLASS];
                   }
                    if(isset($field[self::NS_FORM][self::NS_DEFAULT_VALUE])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_DEFAULT_VALUE] = $field[self::NS_FORM][self::NS_DEFAULT_VALUE];
                    }
                    if(isset($field[self::NS_FORM][self::NS_TYPE])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_TYPE] = $field[self::NS_FORM][self::NS_TYPE];
                        $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_TYPE] = $field[self::NS_FORM][self::NS_TYPE];
                    }
                    if(isset($field[self::NS_FORM][self::NS_DATA_PROVIDER])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_DATA_PROVIDER] = $field[self::NS_FORM][self::NS_DATA_PROVIDER];
                        $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_DATA_PROVIDER] = $field[self::NS_FORM][self::NS_DATA_PROVIDER];

                        if(isset($field[self::NS_FORM][self::NS_MODEL])){
                            $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_MODEL] = $field[self::NS_FORM][self::NS_MODEL];
                            $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_MODEL] = $field[self::NS_FORM][self::NS_MODEL];
                        }

                        if(isset($field[self::NS_FORM][self::NS_METHOD])){
                            $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_METHOD] = $field[self::NS_FORM][self::NS_METHOD];
                            $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_METHOD] = $field[self::NS_FORM][self::NS_METHOD];
                        }

                    }
                    if(isset($field[self::NS_FORM][self::NS_CHOICES])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_CHOICES] = $field[self::NS_FORM][self::NS_CHOICES];
                        $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_CHOICES] = $field[self::NS_FILTER][self::NS_CHOICES];
                    }
                    if(isset($field[self::NS_FORM][self::NS_VALIDATION])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_VALIDATION] = $field[self::NS_FORM][self::NS_VALIDATION];
                        $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_VALIDATION] = $field[self::NS_FORM][self::NS_VALIDATION];
                    }
                    if(isset($field[self::NS_FORM][self::NS_HELPER])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_HELPER] = $field[self::NS_FORM][self::NS_HELPER];
                    }
                    if(isset($field[self::NS_FORM][self::NS_PLACEHOLDER])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_PLACEHOLDER] = $field[self::NS_FORM][self::NS_PLACEHOLDER];
                    }
                    if(isset($field[self::NS_FORM][self::NS_EXPANDED])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_EXPANDED] = $field[self::NS_FORM][self::NS_EXPANDED];
                    }
                    if(isset($field[self::NS_FORM][self::NS_MULTIPLE])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FORM][self::NS_MULTIPLE] = $field[self::NS_FORM][self::NS_MULTIPLE];
                    }
                }

                if(isset($field[self::NS_FILTER])){
                    if(isset($field[self::NS_FILTER][self::NS_CLASS])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_CLASS] = $field[self::NS_FILTER][self::NS_CLASS];
                    }
                     if(isset($field[self::NS_FILTER][self::NS_DEFAULT_VALUE])){
                         $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_DEFAULT_VALUE] = $field[self::NS_FILTER][self::NS_DEFAULT_VALUE];
                     }
                     if(isset($field[self::NS_FILTER][self::NS_TYPE])){
                         $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_TYPE] = $field[self::NS_FILTER][self::NS_TYPE];
                     }
                     if(isset($field[self::NS_FILTER][self::NS_DATA_PROVIDER])){
                         $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_DATA_PROVIDER] = $field[self::NS_FILTER][self::NS_DATA_PROVIDER];
                     }
                     if(isset($field[self::NS_FILTER][self::NS_CHOICES])){
                         $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_CHOICES] = $field[self::NS_FILTER][self::NS_CHOICES];
                     }
                     if(isset($field[self::NS_FILTER][self::NS_VALIDATION])){
                         $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_VALIDATION] = $field[self::NS_FILTER][self::NS_VALIDATION];
                     }
                    if(isset($field[self::NS_FILTER][self::NS_HELPER])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_HELPER] = $field[self::NS_FILTER][self::NS_HELPER];
                    }
                    if(isset($field[self::NS_FILTER][self::NS_PLACEHOLDER])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_PLACEHOLDER] = $field[self::NS_FILTER][self::NS_PLACEHOLDER];
                    }
                    if(isset($field[self::NS_FILTER][self::NS_EXPANDED])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_EXPANDED] = $field[self::NS_FILTER][self::NS_EXPANDED];
                    }
                    if(isset($field[self::NS_FILTER][self::NS_MULTIPLE])){
                        $this->fields[$field[self::NS_NAME]][self::NS_FILTER][self::NS_MULTIPLE] = $field[self::NS_FILTER][self::NS_MULTIPLE];
                    }
                }

            }

        }

    }

    protected function parseTableFieldSets($json_config_fieldsets){
        foreach($json_config_fieldsets as $fieldset){

            if(!isset($fieldset[self::NS_NAME])){
                throw new \Exception("AG Configuration: Fieldsets should have name");
            }

            if(!isset($this->fieldSets[$fieldset[self::NS_NAME]])){
                $this->fieldSets[$fieldset[self::NS_NAME]] = [];
            }

            if(isset($fieldset[self::NS_CLASS])){
                $this->fieldSets[$fieldset[self::NS_NAME]][self::NS_CLASS] = $fieldset[self::NS_CLASS];
            }else{
                $this->fieldSets[$fieldset[self::NS_NAME]][self::NS_CLASS] = "primary";
            }
        }
    }

    protected function parseListItems($json_config_list){

        $this->listTitle = __('":model" List', [
            'model' => __($this->modelName)
        ]);

        if(isset($json_config_list[self::NS_TITLE])){

            $this->listTitle = __($json_config_list[self::NS_TITLE], [
                'model' => __($this->modelName)
            ]);

        }

        $this->listItems = [];

        if(isset($json_config_list[self::NS_DISPLAY])){

            if(!is_array($json_config_list[self::NS_DISPLAY])){
                throw new \Exception("AG Configuration: List Display should be array");
            }

            foreach($json_config_list[self::NS_DISPLAY] as $item){
                if(isset($this->fields[$item][self::NS_IN_INDEX]) && $this->fields[$item][self::NS_IN_INDEX] == false){
                    // do nothing
                }else{
                    $this->listItems[] = $item;
                }
            }

        }else{

            foreach($this->fields as $item_key => $item_val){
                if(isset($item_val[self::NS_IN_INDEX]) && $item_val[self::NS_IN_INDEX] == true){
                    $this->listItems[] = $item_key;
                }elseif(self::DEFAULT_IN_INDEX == true){
                    $this->listItems[] = $item_key;
                }
            }

        }

        if(isset($json_config_list[self::NS_QUERY])){
            $query = $json_config_list[self::NS_QUERY];
            if(!method_exists($this->repository, $query)){
                throw new \Exception("AG Configuration: List Query Method Not Exists: " . get_class($this->repository) . '::' . $query);
            }

            $this->listQuery = $query;
        }

        if(isset($json_config_list[self::NS_SORT])){
            $this->listSort = $json_config_list[self::NS_SORT];
        }

        // count per page
        if(isset($json_config_list[self::NS_COUNT_PER_PAGE])){
            $this->perPage = $json_config_list[self::NS_COUNT_PER_PAGE];
        }

        // fill searchable fields.
        foreach($this->fields as $key => $field){
            if(isset($field[self::NS_SEARCHABLE])){
                if($field[self::NS_SEARCHABLE] == true){
                    $this->repository->fieldSearchable[] = $key;
                }
            }else{
                if(self::DEFAULT_SEARCHABLE == true){
                    $this->repository->fieldSearchable[] = $key;
                }
            }
        }


        // process object actions
        $this->parseListObjectActions($json_config_list);
        $this->parseGeneralActions($json_config_list);
        $this->parseBatchActions($json_config_list);
        $this->parseListActions($json_config_list);


    }

    protected function parseFilterItems($json_config_filter){

        $this->filterSession = 'generator_' . $this->modelName;
        if(isset($json_config_filter[self::NS_SESSION_PREFIX])){
            $this->filterSession = $json_config_filter[self::NS_SESSION_PREFIX];
        }

        if(isset($json_config_filter[self::NS_DISPLAY])){

            if(!is_array($json_config_filter[self::NS_DISPLAY])){
                throw new \Exception("AG Configuration: Filter Display should be array");
            }

            foreach($json_config_filter[self::NS_DISPLAY] as $item){
                if(isset($this->fields[$item][self::NS_SEARCHABLE]) && $this->fields[$item][self::NS_SEARCHABLE] == false){
                    // do nothing
                }else{
                    $this->filterItems[] = $item;
                }
            }

        }else{

            foreach($this->fields as $item_key => $item_val){
                if(isset($item_val[self::NS_SEARCHABLE]) && $item_val[self::NS_SEARCHABLE] == true){
                    $this->filterItems[] = $item_key;
                }elseif(self::DEFAULT_SEARCHABLE == true){
                    $this->filterItems[] = $item_key;
                }
            }

        }

    }


    protected function parseNewItems($json_config_new){

        $this->newTitle = __('New :model', [
            'model' => __($this->modelName)
        ]);

        if(isset($json_config_new[self::NS_TITLE])){
            $this->newTitle = __($json_config_new[self::NS_TITLE], [
                'model' => __($this->modelName)
            ]);
        }

        $this->parseCreateActions($json_config_new);

    }

    protected function parseEditItems($json_config_edit){

        $this->editTitle = __('Edit :model', [
            'model' => __($this->modelName)
        ]);

        if(isset($json_config_edit[self::NS_TITLE])){
            $this->editTitle = __($json_config_edit[self::NS_TITLE], [
                'model' => __($this->modelName)
            ]);
        }

        $this->parseEditActions($json_config_edit);

    }

    protected function parseShowItems($json_config_show){

        $this->showTitle = __('Show :model', [
            'model' => __($this->modelName)
        ]);

        if(isset($json_config_show[self::NS_TITLE])){
            $this->showTitle = __($json_config_show[self::NS_TITLE], [
                'model' => __($this->modelName)
            ]);
        }

        $this->parseShowActions($json_config_show);

    }

    protected function parseExcelItems($json_config_list){

        $this->excelItems = [];

        if(isset($json_config_list[self::NS_DISPLAY])){

            if(!is_array($json_config_list[self::NS_DISPLAY])){
                throw new \Exception("AG Configuration: List Display should be array");
            }

            foreach($json_config_list[self::NS_DISPLAY] as $item){
                if(isset($this->fields[$item][self::NS_IN_INDEX]) && $this->fields[$item][self::NS_IN_INDEX] == false){
                    // do nothing
                }else{
                    $this->excelItems[] = $item;
                }
            }

        }else{

            foreach($this->fields as $item_key => $item_val){
                if(isset($item_val[self::NS_IN_INDEX]) && $item_val[self::NS_IN_INDEX] == true){
                    $this->excelItems[] = $item_key;
                }elseif(self::DEFAULT_IN_INDEX == true){
                    $this->excelItems[] = $item_key;
                }
            }

        }

    }


    protected function parseFormItems($json_config_display, &$formItems, $checkInForm = true){

        if(isset($json_config_display[self::NS_DISPLAY])){

            if(!is_array($json_config_display[self::NS_DISPLAY])){
                throw new \Exception("AG Configuration: Edit Display should be array");
            }

            $formItems = [];

            foreach($json_config_display[self::NS_DISPLAY] as $fieldset => $item){

                if(is_array($item)){

                    if(!isset($formItems[$fieldset])){
                        $formItems[$fieldset] = [];
                    }

                    foreach($item as $field){
                        if($checkInForm && isset($this->fields[$field][self::NS_IN_FORM]) && $this->fields[$field][self::NS_IN_FORM] == false){
                            // do nothing
                        }else{
                            $formItems[$fieldset][] = $field;
                        }
                    }

                }else{

                    if(!isset($formItems["default"])){
                        $formItems["default"] = [];
                    }

                    if($checkInForm &&  isset($this->fields[$item][self::NS_IN_FORM]) && $this->fields[$item][self::NS_IN_FORM] == false){
                        // do nothing
                    }else{
                        $formItems["default"][] = $item;
                    }
                }

            }

        }else{

            if(sizeof($formItems) == 0){
                $formItems["default"] = [];

                foreach($this->fields as $item_key => $item_val){
                    if($checkInForm && isset($item_val[self::NS_IN_FORM]) && $item_val[self::NS_IN_FORM] == true){
                        $formItems["default"][] = $item_key;
                    }elseif($checkInForm && self::DEFAULT_IN_FORM == true){
                        $formItems["default"][] = $item_key;
                    }elseif($checkInForm == false){
                        $formItems["default"][] = $item_key;
                    }
                }
            }
        }

    }

    protected function buildFieldFormStructure($column, $columnStructures){
        //dd($columnStructures);
        foreach($columnStructures as $columnStructure){
            if($columnStructure->Field == $column) {
                $output_array = [];
                preg_match('/^([\w]+)(\(([\d]+)*(,([\d]+))*\))*(.+)*$/', $columnStructure->Type, $output_array);

                $type = $output_array[1];
                $size = isset($output_array[3]) ? $output_array[3] : null;
                $isNull = $columnStructure->Null;
                $key = $columnStructure->Key;
                $default = $columnStructure->Default;
                $extra = $columnStructure->Extra;
                $validationForm = [];
                $validationFilter = [];

                if (!isset($this->fields[$column][self::NS_FORM])) {
                    $this->fields[$column][self::NS_FORM] = [];
                    $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-default';
                }

                if (!isset($this->fields[$column][self::NS_FILTER])) {
                    $this->fields[$column][self::NS_FILTER] = [];
                    $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-default';
                }

                // DEFAULT VALUE
                $this->fields[$column][self::NS_FORM][self::NS_DEFAULT_VALUE] = $default;

                // REQUIRED VALIDATON
                if($isNull == 'NO'){
                    $validationForm[] = 'required';
                    $this->fields[$column][self::NS_FORM][self::NS_HELPER] = __('*') . ' ';
                }else{
                    $validationForm[] = 'nullable';
                    $this->fields[$column][self::NS_FORM][self::NS_HELPER] = '';
                }
                $validationFilter[] = 'nullable';

                switch (strtolower($type)){
                    case "int":
                    case "bigint":

                        $this->fields[$column][self::NS_DB_TYPE] = self::DB_TYPE_INT;

                        if($key == "PRI" && $extra == 'auto_increment') {
                            $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'hidden';
                            $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'text';
                            $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';

                        }elseif($key == "MUL"){
                            $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'select';
                            $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'select';
                        }else{
                            $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'text';
                            $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'text';
                            $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-ltr';
                            $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';
                        }

                        break;

                    case "varchar":
                    case "text":
                    case "string":
                    case "longtext":

                        $this->fields[$column][self::NS_DB_TYPE] = self::DB_TYPE_TEXT;

                        if($size == null || $size <= 256){
                            $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'text';
                        }else{
                            $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'textarea';
                        }

                        $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'text';

                        $validationForm[] = 'string';
                        $validationFilter[] = 'string';
                        if($size != null){
                            $validationForm[] = 'max:' . $size;
                        }

                        break;
                    case "timestamp":
                    case "datetime":

                        $this->fields[$column][self::NS_DB_TYPE] = self::DB_TYPE_DATE;

                        $validationForm[] = 'date';
                        $validationFilter[] = 'date';

                        $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'datetime';
                        $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'datetime_range';

                        break;

                    case "tinyint":
                    case "boolean":
                    case "bool":

                        $this->fields[$column][self::NS_DB_TYPE] = self::DB_TYPE_INT;

                        $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'checkbox';
                        $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'select';

                        if (($key = array_search('required', $validationForm)) !== false) {
                            unset($validationForm[$key]);
                            $this->fields[$column][self::NS_FORM][self::NS_HELPER] = '';
                        }

                        if (($key = array_search('required', $validationFilter)) !== false) {
                            unset($validationFilter[$key]);
                            $this->fields[$column][self::NS_FORM][self::NS_HELPER] = '';
                        }

                        if (\Illuminate\Support\Facades\App::getLocale() == "fa") {
                            $this->fields[$column][self::NS_FILTER][self::NS_CHOICES] = [
                                '' => __('بله یا خیر'),
                                '1' => __('بله'),
                                '0' => __('خیر')
                            ];

                        } else {
                            $this->fields[$column][self::NS_FILTER][self::NS_CHOICES] = [
                                '' => __('Yes or No'),
                                '1' => __('Yes'),
                                '0' => __('No')
                            ];
                        }


                        break;
                    default:
                        $this->fields[$column][self::NS_DB_TYPE] = self::DB_TYPE_TEXT;
                        $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'text';
                        $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'text';
                        break;
                }

                switch (strtolower($column)) {
                    case "url":
                    case "link":
                    case "uri":
                        $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FORM][self::NS_HELPER] .= '(Ex: http://www.yourwebsite.com)';
                        $validationForm[] = 'url';
                        break;

                    case "password":
                        $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'password';
                        $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'password';
                        $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';
                        break;

                    case "email":
                    case "support_email":
                        $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FORM][self::NS_HELPER] .= '(Ex: youremail@domain.com)';
                        $validationForm[] = 'email';
                        break;

                    case "phone":
                    case "support_phone":
                        $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FORM][self::NS_HELPER] .= '(Ex: +982100000000)';
                        break;
                    case "mobile":
                        $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FORM][self::NS_HELPER] .= '(Ex: 09120000000)';
                        break;

                    case "gender":
                    case "sex":
                        $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'select';
                        $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'select';
                        $this->fields[$column][self::NS_FORM][self::NS_CHOICES] = [
                            'm' => __('مرد'),
                            'f' => __('زن')
                        ];

                        $this->fields[$column][self::NS_FILTER][self::NS_CHOICES] = [
                            ''  => __('مرد یا زن'),
                            'm' => __('مرد'),
                            'f' => __('زن')
                        ];

                        $this->fields[$column][self::NS_FORM][self::NS_EXPANDED] = true;
                        $this->fields[$column][self::NS_FORM][self::NS_MULTIPLE] = false;

                        $validationForm[] = 'in:m,f';
                        $validationFilter[] = 'in:m,f,';
                        break;

                    case "melli_code":
                    case "mellicode":
                    case "national_number":
                    case "national_code":
                    $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-ltr';
                    $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';
                    $this->fields[$column][self::NS_FORM][self::NS_MASK] = "9999999999";
                        break;

                    case "username":
                    $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-ltr';
                    $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';
                        break;

                    case "created_at":
                    case "updated_at":
                    case "deleted_at":
                        break;

                    case "date":
                    case "from_date":
                    case "date_from":
                    case "to_date":
                    case "date_to":
                    case "begin_date":
                    case "end_date":
                        $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'date';
                        $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'date_range';
                        $validationForm[] = 'date';
                        $validationFilter[] = 'date';
                        break;

                    case "ip":
                    case "ip_address":
                        $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FORM][self::NS_MASK] = 'ip';
                        $validationForm[] = 'ip';
                        $validationFilter[] = 'ip';
                        break;

                    case "file":
                    case "picture":
                        $this->fields[$column][self::NS_FORM][self::NS_TYPE] = 'file';
                        $this->fields[$column][self::NS_FILTER][self::NS_TYPE] = 'hidden';
                        break;

                    case "descriptor":
                        $this->fields[$column][self::NS_FORM][self::NS_CLASS] = 'dir-ltr';
                        $this->fields[$column][self::NS_FILTER][self::NS_CLASS] = 'dir-ltr';
                }

                $this->fields[$column][self::NS_FORM][self::NS_VALIDATION] = $validationForm;
                $this->fields[$column][self::NS_FILTER][self::NS_VALIDATION] = $validationFilter;

                break;

            }
        }
    }

    protected function parseListObjectActions($json_config){

        if(!isset($json_config[self::NS_OBJECT_ACTIONS])){
            $this->objectActions = $this->defaultObjectActions;
        }else{
            $this->objectActions = [];

            $objectActions = $json_config[self::NS_OBJECT_ACTIONS];
            foreach($objectActions as $objectAction){

                if(!isset($objectAction[self::NS_NAME])){
                    throw new \Exception("AG Configuration: Object Actions should have key: name");
                }

                $foundInDefaults = false;
                if(isset($this->defaultObjectActions[$objectAction[self::NS_NAME]])){
                    $action = $this->defaultObjectActions[$objectAction[self::NS_NAME]];
                    $foundInDefaults = true;
                }else{
                    $action = [];
                }

                if(isset($objectAction[self::NS_ROUTE])){
                    $action[self::NS_ROUTE] = $objectAction[self::NS_ROUTE];
                }elseif(!$foundInDefaults){
                    $action[self::NS_ROUTE] = $objectAction[self::NS_NAME];
                }

                if(isset($objectAction[self::NS_CLASS])){
                    $action[self::NS_CLASS] = $objectAction[self::NS_CLASS];
                }

                if(isset($objectAction[self::NS_ICON])){
                    $action[self::NS_ICON] = $objectAction[self::NS_ICON];
                }elseif(!$foundInDefaults){
                    $action[self::NS_ICON] = self::DEFAULT_ICON;
                }

                if(isset($objectAction[self::NS_TYPE])){
                    $action[self::NS_TYPE] = $objectAction[self::NS_TYPE];
                }elseif(!$foundInDefaults){
                    $action[self::NS_TYPE] = self::BUTTON_TYPE_LINK;
                }

                if(isset($objectAction[self::NS_LABEL])){
                    $action[self::NS_LABEL] = $objectAction[self::NS_LABEL];
                }else{
                    $action[self::NS_LABEL] = $objectAction[self::NS_NAME];
                }

                if(isset($objectAction[self::NS_CONFIRM])){
                    $action[self::NS_CONFIRM] = $objectAction[self::NS_CONFIRM];
                }

                if(isset($objectAction[self::NS_METHOD])){
                    $action[self::NS_METHOD] = $objectAction[self::NS_METHOD];
                }elseif(!$foundInDefaults){
                    $action[self::NS_METHOD] = 'post';
                }

                $this->objectActions[$objectAction[self::NS_NAME]] = $action;

            }
        }
    }

    protected function parseListActions($json_config){

        if(!isset($json_config[self::NS_ACTIONS])){
            $this->listActions = $this->defaultListActions;
        }else{
            $this->listActions = [];

            $listActions = $json_config[self::NS_ACTIONS];
            foreach($listActions as $listAction){

                if(!isset($listAction[self::NS_NAME])){
                    throw new \Exception("AG Configuration: List Actions should have key: name");
                }

                $foundInDefaults = false;
                if(isset($this->defaultListActions[$listAction[self::NS_NAME]])){
                    $foundInDefaults = true;
                    $action = $this->defaultListActions[$listAction[self::NS_NAME]];
                }else{
                    $action = [];
                }

                if(isset($listAction[self::NS_ROUTE])){
                    $action[self::NS_ROUTE] = $listAction[self::NS_ROUTE];
                }

                if(isset($listAction[self::NS_CLASS])){
                    $action[self::NS_CLASS] = $listAction[self::NS_CLASS];
                }

                if(isset($listAction[self::NS_LABEL])){
                    $action[self::NS_LABEL] = $listAction[self::NS_LABEL];
                }elseif(!$foundInDefaults){
                    $action[self::NS_LABEL] = $listAction[self::NS_NAME];
                }

                $this->listActions[$listAction[self::NS_NAME]] = $action;

            }
        }

    }

    protected function parseEditActions($json_config){

        if(!isset($json_config[self::NS_ACTIONS])){
            $this->editActions = $this->defaultEditActions;
        }else{

            $this->editActions = [];

            $listActions = $json_config[self::NS_ACTIONS];
            foreach($listActions as $listAction){

                if(!isset($listAction[self::NS_NAME])){
                    throw new \Exception("AG Configuration: Actions should have key: name");
                }

                $foundInDefaults = false;
                if(isset($this->defaultEditActions[$listAction[self::NS_NAME]])){
                    $action = $this->defaultEditActions[$listAction[self::NS_NAME]];
                    $foundInDefaults = true;
                }else{
                    $action = [];
                }

                if(isset($listAction[self::NS_ROUTE])){
                    $action[self::NS_ROUTE] = $listAction[self::NS_ROUTE];
                }

                if(isset($listAction[self::NS_CLASS])){
                    $action[self::NS_CLASS] = $listAction[self::NS_CLASS];
                }

                if(isset($listAction[self::NS_LABEL])){
                    $action[self::NS_LABEL] = $listAction[self::NS_LABEL];
                }elseif(!$foundInDefaults){
                    $action[self::NS_LABEL] = $listAction[self::NS_NAME];
                }


                if(isset($listAction[self::NS_TYPE])){
                    $action[self::NS_TYPE] = $listAction[self::NS_TYPE];
                }elseif(!$foundInDefaults){
                    $action[self::NS_TYPE] = self::BUTTON_TYPE_LINK;
                }

                $this->editActions[$listAction[self::NS_NAME]] = $action;

            }
        }

    }

    protected function parseCreateActions($json_config){

        if(!isset($json_config[self::NS_ACTIONS])){
            $this->createActions = $this->defaultCreateActions;
        }else{

            $this->createActions = [];

            $listActions = $json_config[self::NS_ACTIONS];
            foreach($listActions as $listAction){

                if(!isset($listAction[self::NS_NAME])){
                    throw new \Exception("AG Configuration: Actions should have key: name");
                }

                $foundInDefaults = false;
                if(isset($this->defaultCreateActions[$listAction[self::NS_NAME]])){
                    $action = $this->defaultCreateActions[$listAction[self::NS_NAME]];
                    $foundInDefaults = true;
                }else{
                    $action = [];
                }

                if(isset($listAction[self::NS_ROUTE])){
                    $action[self::NS_ROUTE] = $listAction[self::NS_ROUTE];
                }

                if(isset($listAction[self::NS_CLASS])){
                    $action[self::NS_CLASS] = $listAction[self::NS_CLASS];
                }

                if(isset($listAction[self::NS_LABEL])){
                    $action[self::NS_LABEL] = $listAction[self::NS_LABEL];
                }elseif(!$foundInDefaults){
                    $action[self::NS_LABEL] = $listAction[self::NS_NAME];
                }


                if(isset($listAction[self::NS_TYPE])){
                    $action[self::NS_TYPE] = $listAction[self::NS_TYPE];
                }elseif(!$foundInDefaults){
                    $action[self::NS_TYPE] = self::BUTTON_TYPE_LINK;
                }

                $this->createActions[$listAction[self::NS_NAME]] = $action;

            }
        }

    }

    protected function parseBatchActions($json_config){

        if(!isset($json_config[self::NS_BATCH_ACTIONS])){
            $this->batchActions = $this->defaultBatchActions;
        }else{

            $this->batchActions = [];

            $listActions = $json_config[self::NS_BATCH_ACTIONS];
            foreach($listActions as $listAction){

                if(!isset($listAction[self::NS_NAME])){
                    throw new \Exception("AG Configuration: Actions should have key: name");
                }

                $foundInDefaults = false;
                if(isset($this->defaultBatchActions[$listAction[self::NS_NAME]])){
                    $action = $this->defaultBatchActions[$listAction[self::NS_NAME]];
                    $foundInDefaults = true;
                }else{
                    $action = [];
                }

                if(isset($listAction[self::NS_LABEL])){
                    $action[self::NS_LABEL] = $listAction[self::NS_LABEL];
                }elseif(!$foundInDefaults){
                    $action[self::NS_LABEL] = $listAction[self::NS_NAME];
                }


                $this->batchActions[$listAction[self::NS_NAME]] = $action;

            }
        }

    }

    protected function parseGeneralActions($json_config){

        if(!isset($json_config[self::NS_GENERAL_ACTIONS])){
            $this->generalActions = $this->defaultGeneralActions;
        }else{

            $this->generalActions = [];

            $listActions = $json_config[self::NS_GENERAL_ACTIONS];
            foreach($listActions as $listAction){

                if(!isset($listAction[self::NS_NAME])){
                    throw new \Exception("AG Configuration: General Actions should have key: name");
                }

                $foundInDefaults = false;
                if(isset($this->defaultGeneralActions[$listAction[self::NS_NAME]])){
                    $action = $this->defaultGeneralActions[$listAction[self::NS_NAME]];
                    $foundInDefaults = true;
                }else{
                    $action = [];
                }

                if(isset($listAction[self::NS_ROUTE])){
                    $action[self::NS_ROUTE] = $listAction[self::NS_ROUTE];
                }

                if(isset($listAction[self::NS_CLASS])){
                    $action[self::NS_CLASS] = $listAction[self::NS_CLASS];
                }

                if(isset($listAction[self::NS_LABEL])){
                    $action[self::NS_LABEL] = $listAction[self::NS_LABEL];
                }elseif(!$foundInDefaults){
                    $action[self::NS_LABEL] = $listAction[self::NS_NAME];
                }

                $this->generalActions[$listAction[self::NS_NAME]] = $action;

            }
        }

    }

    protected function parseShowActions($json_config){

        if(!isset($json_config[self::NS_ACTIONS])){
            $this->showActions = $this->defaultShowActions;
        }else{

            $this->showActions = [];

            $listActions = $json_config[self::NS_ACTIONS];
            foreach($listActions as $listAction){

                if(!isset($listAction[self::NS_NAME])){
                    throw new \Exception("AG Configuration: Actions should have key: name");
                }

                $foundInDefaults = false;
                if(isset($this->defaultShowActions[$listAction[self::NS_NAME]])){
                    $action = $this->defaultShowActions[$listAction[self::NS_NAME]];
                    $foundInDefaults = true;
                }else{
                    $action = [];
                }

                if(isset($listAction[self::NS_ROUTE])){
                    $action[self::NS_ROUTE] = $listAction[self::NS_ROUTE];
                }

                if(isset($listAction[self::NS_CLASS])){
                    $action[self::NS_CLASS] = $listAction[self::NS_CLASS];
                }

                if(isset($listAction[self::NS_LABEL])){
                    $action[self::NS_LABEL] = $listAction[self::NS_LABEL];
                }elseif(!$foundInDefaults){
                    $action[self::NS_LABEL] = $listAction[self::NS_NAME];
                }

                if(isset($listAction[self::NS_TYPE])){
                    $action[self::NS_TYPE] = $listAction[self::NS_TYPE];
                }elseif(!$foundInDefaults){
                    $action[self::NS_TYPE] = self::BUTTON_TYPE_LINK;
                }

                if(isset($listAction[self::NS_METHOD])){
                    $action[self::NS_METHOD] = $listAction[self::NS_METHOD];
                }elseif(!$foundInDefaults){
                    $action[self::NS_METHOD] = 'post';
                }

                if(isset($listAction[self::NS_CONFIRM])){
                    $action[self::NS_CONFIRM] = $listAction[self::NS_CONFIRM];
                }

                $this->showActions[$listAction[self::NS_NAME]] = $action;

            }
        }

    }


    protected $defaultObjectActions = [
        'show' => [
            'route' => 'show',
            'class' => 'btn btn-default btn-xs',
            'icon' => 'glyphicon glyphicon-eye-open',
            'type' => self::BUTTON_TYPE_LINK,
            'label' => 'generator.show'
        ],
        'edit' => [
            'route' => 'edit',
            'class' => 'btn btn-default btn-xs',
            'icon' => 'glyphicon glyphicon-edit',
            'type' => self::BUTTON_TYPE_LINK,
            'label' => 'generator.edit'
        ],
        'delete' => [
            'route' => 'destroy',
            'class' => 'btn btn-danger btn-xs',
            'icon' => 'glyphicon glyphicon-trash',
            'type' => self::BUTTON_TYPE_SUBMIT,
            'confirm' => 'generator.are_you_sure',
            'label' => 'generator.delete',
            'method' => 'delete',
        ]
    ];

    protected $defaultListActions = [
        'create' => [
            'route' => 'create',
            'class' => 'btn btn-primary',
            'label' => 'generator.add_new'
        ]
    ];

    protected $defaultEditActions = [
        'list' => [
            'route' => 'index',
            'class' => 'btn btn-default',
            'label' => 'generator.list',
            'type' => self::BUTTON_TYPE_LINK
        ],
        'save' => [
            'label' => 'generator.save',
            'type' => self::BUTTON_TYPE_SUBMIT
        ]
    ];

    protected $defaultCreateActions = [
        'list' => [
            'route' => 'index',
            'class' => 'btn btn-default',
            'label' => 'generator.cancel',
            'type' => self::BUTTON_TYPE_LINK
        ],
        'save' => [
            'label' => 'generator.save',
            'type' => self::BUTTON_TYPE_SUBMIT,
        ],
        'save_and_add' => [
            'label' => 'generator.save_and_add',
            'type' => self::BUTTON_TYPE_SUBMIT,
        ]

    ];

    protected $defaultBatchActions = [
        'batchDelete' => [
            'label' => 'generator.delete',
        ],
        'batchExportExcel' => [
            'label' => 'generator.exportExcel',
        ]
    ];

    protected $defaultGeneralActions = [
        'exportExcel' => [
            'route' => 'exportExcel',
            'class' => 'btn btn-success',
            'label' => 'generator.exportExcel',
        ]
    ];

    protected $defaultShowActions = [
        'delete' => [
            'route' => 'destroy',
            'class' => 'btn btn-danger',
            'type' => self::BUTTON_TYPE_SUBMIT,
            'confirm' => 'generator.are_you_sure',
            'label' => 'generator.delete',
            'method' => 'delete',
        ],
        'list' => [
            'route' => 'index',
            'class' => 'btn btn-default',
            'label' => 'generator.list',
            'type' => self::BUTTON_TYPE_LINK,
        ]
    ];

}