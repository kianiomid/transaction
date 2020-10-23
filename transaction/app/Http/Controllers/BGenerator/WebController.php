<?php namespace App\Http\Controllers\BGenerator;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Session;
use Request;
use Config;
use File;
use Input;
use Auth;
use DB;
use Flash;
use Validator;


class WebController extends BaseController {

    public function __construct($configFile)
    {
        parent::__construct($configFile);
    }

    public function index(\Illuminate\Http\Request $request){

        // set default limit, default order
        // $fieldSearchable

        // Apply Filter
        $filterCriteria = $request->session()->get($this->filterSession, [
            'searchFilter' => [],
            'page' => $request->get('page', 1),
            'sortField' => null,
            'sortOrder' => null
        ]);

        if($request->has('page')) {
            $filterCriteria['page'] = $request->get('page', 1);
        }

        if($request->has('sort')) {
            $filterCriteria['sortField'] = $request->get('sort');
        }

        if($request->has('sortOrder')) {
            $filterCriteria['sortOrder'] = $request->get('sortOrder');
        }

        if($request->has('_reset') && $request->get('_reset') == 1){
            $filterCriteria = [
                'searchFilter' => [],
                'page' => 1,
                'sortField' => null,
                'sortOrder' => null
            ];
        }

        $request->session()->put($this->filterSession, $filterCriteria);

        $this->repository->applyFilter($this->fields, $this->filterItems, $filterCriteria['searchFilter']);

        // fill relations and choices for data providers
        $this->fillFilterRelations($this->filterItems);

        if($this->listQuery != null){
            $this->repository->{$this->listQuery}();
        }
        // End Apply Filter ------------------------------------------

        $this->prepareListSort($filterCriteria['sortField'], $filterCriteria['sortOrder']);

        $items = $this->repository->applyPagination($this->perPage, ['*'], "paginate", $filterCriteria['page']);

        return view($this->skeleton . '.index')
            //->withErrors($validator)
            ->with([
                'items'         => $items,
                'fields'        =>  $this->fields,
                'headerItems'   => $this->listItems,
                'title'         => $this->listTitle,
                'filterItems'   => $this->filterItems,
                'formDefaults'  => $filterCriteria['searchFilter'],
                'customView'    => $this->params[self::NS_CUSTOM_VIEW],
                'modelName'         => $this->modelName,
                'batchActions'      => $this->batchActions,
                'objectActions'     => $this->objectActions,
                'generalActions'    => $this->generalActions,
                'listActions'            => $this->listActions,
                'sortField'              =>  $this->sortField,
                'sortOrder'              =>   $this->sortOrder
            ]);

    }

    public function filter(\Illuminate\Http\Request $request){

        // Apply Filter
        $filterCriteria = $request->session()->get($this->filterSession, [
            'searchFilter' => [],
            'page' => 1,
            'sortField' => null,
            'sortOrder' => null
        ]);

        if($request->isMethod('post')){

            $input = $this->getRequestParameters($this->filterItems);

            // filter validation
            $validationRules = $this->prepareFilterValidation($this->filterItems);
            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()) {

                Flash::error('The filter is not set due to some errors');

            }else{
                foreach($input as $inKey => $inValue){
                    if($inKey == '_token')
                        continue;
                    $filterCriteria['searchFilter'][$inKey] = $inValue;
                }
            }

        }

        $filterCriteria['page'] = $request->get('page', 1);

        $request->session()->put($this->filterSession, $filterCriteria);

        return redirect(route($this->modelName . '.index'));

    }

    public function create()
    {
        // fill relations and choices for data providers
        $this->fillFormRelations($this->newItems);

        return view($this->skeleton . '.create')->with([
            'fields'        => $this->fields,
            'title'         => $this->newTitle,
            'customView'    => $this->params[self::NS_CUSTOM_VIEW],
            'formFieldSets'     => $this->newItems,
            'fieldSetsSkeleton' => $this->fieldSets,
            'modelName'         => $this->modelName,
            'actions'           => $this->createActions
        ]);

    }

    public function store(\Illuminate\Http\Request $request)
    {

        $input = $this->getRequestParameters($this->newItems);

        // validation
        $validationRules = $this->prepareFormValidation($this->fields, $this->newItems);

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {

            Flash::error(__('generator.The form is not saved due to some errors'));

            // fill relations and choices for data providers
            $this->fillFormRelations($this->newItems);

            return view($this->skeleton .'.create')
                ->withErrors($validator)
                ->withInput($input)
                ->with([
                    'fields'        => $this->fields,
                    'title'         => $this->newTitle,
                    'customView'    => $this->params[self::NS_CUSTOM_VIEW],
                    'formFieldSets'     => $this->newItems,
                    'fieldSetsSkeleton' => $this->fieldSets,
                    'modelName'         => $this->modelName,
                    'actions'           => $this->createActions
            ]);

        }

        // save and add

        $item = $this->repository->create($input);

        if(isset($input['save_and_add'])){
            Flash::success(__('generator.create_and_add_success_message'));
            return redirect(route($this->modelName . '.create'));
        }else{
            Flash::success(__('generator.create_success_message'));
            return redirect(route($this->modelName . '.edit', [$item->id]));
        }

    }

    public function edit($id){

        if($this->listQuery != null){
            $this->repository->{$this->listQuery}();
        }

        $item = $this->repository->findWithoutFail($id);

        if (empty($item)) {
            Flash::error(__('generator.item_not_found'));
            return redirect(route($this->modelName . '.index'));
        }

        // fill relations and choices for data providers
        $this->fillFormRelations($this->editItems, $item);

        return view($this->skeleton .'.edit')->with([
            'fields'        => $this->fields,
            'item'          => $item,
            'title'         => $this->editTitle,
            'customView'    => $this->params[self::NS_CUSTOM_VIEW],
            'formFieldSets'     => $this->editItems,
            'fieldSetsSkeleton' => $this->fieldSets,
            'modelName'         => $this->modelName,
            'actions'           => $this->editActions
        ]);

    }

    public function update($id, \Illuminate\Http\Request $request)
    {
        $item = $this->repository->findWithoutFail($id);

        if (empty($item)) {
            Flash::error(__('generator.item_not_found'));
            return redirect(route($this->modelName . '.index'));
        }

        $input = $this->getRequestParameters($this->editItems);

        // validation
        $validationRules = $this->prepareFormValidation($this->fields, $this->editItems, $item);

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {

            Flash::error(__('generator.The form is not saved due to some errors'));

            // fill relations and choices for data providers
            $this->fillFormRelations($this->editItems, $item);

            return view($this->skeleton . '.edit')
                ->withErrors($validator)
                ->withInput($input)
                ->with([
                    'fields'        => $this->fields,
                    'item'          => $item,
                    'title'         => $this->editTitle,
                    'customView'    => $this->params[self::NS_CUSTOM_VIEW],
                    'formFieldSets'     => $this->editItems,
                    'fieldSetsSkeleton' => $this->fieldSets,
                    'modelName'         => $this->modelName,
                    'actions'           => $this->editActions
            ]);

        }
        $item = $this->repository->update($input, $id);

        Flash::success(__('generator.Item updated successfully'));

        return redirect(route($this->modelName . '.edit', [$item->id]));
    }

    public function show($id)
    {

        if($this->listQuery != null){
            $this->repository->{$this->listQuery}();
        }

        $item = $this->repository->findWithoutFail($id);

        if (empty($item)) {
            Flash::error(__('generator.item_not_found'));

            return redirect(route($this->modelName.'.index'));
        }

        return view($this->skeleton . '.show')->with([
            'fields'        => $this->fields,
            'item'          => $item,
            'title'         => $this->showTitle,
            'customView'    => $this->params[self::NS_CUSTOM_VIEW],
            'formFieldSets'     => $this->showItems,
            'fieldSetsSkeleton' => $this->fieldSets,
            'modelName' => $this->modelName,
            'actions'   => $this->showActions
        ]);
    }

    public function destroy($id)
    {
        $item = $this->repository->findWithoutFail($id);

        if (empty($item)) {
            Flash::error(__('generator.item_not_found'));

            return redirect(route($this->modelName.'.index'));
        }

        $this->repository->delete($id);

        Flash::success(__('generator.delete_success_message'));

        return redirect(route($this->modelName.'.index'));
    }

    public function exportExcel(\Illuminate\Http\Request $request){

        // Apply Filter
        $filterCriteria = $request->session()->get($this->filterSession, [
            'searchFilter' => [],
            'page' => $request->get('page', 1),
            'sortField' => null,
            'sortOrder' => null
        ]);

        $this->repository->applyFilter($this->fields, $this->filterItems, $filterCriteria['searchFilter']);

        // End Apply Filter ------------------------------------------

        $this->prepareListSort($filterCriteria['sortField'], $filterCriteria['sortOrder']);

        $items = $this->repository->get();

        return $this->exportItemsToExcel($items);

    }

    public function batchAction(){

        $input = request()->all();

        $validationRules = [
            'ids' => 'required',
            "batchAction" => "required"
        ];

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {
            Flash::error(__('generator.The form is not processed due to some errors'));
            return redirect(route($this->modelName.'.index'));
        }

        $ids = explode(",", $input['ids']);
        $batchAction = $input['batchAction'];

        return $this->{$batchAction}($ids);

    }

    protected function batchDelete($ids){

        $countDone = 0;
        foreach($ids as $id){

            $item = $this->repository->findWithoutFail($id);

            if (!empty($item)) {
                if($this->repository->delete($id) !== false){
                    $countDone++;
                };
            }

        }

        if($countDone == 0){
            Flash::error(__('generator.no_item_is_deleted_because_of_errors'));
        }elseif(sizeof($ids) > $countDone){
            Flash::error(__('generator.some_item_is_not_deleted_because_of_errors', [
                'count' => sizeof($ids) - $countDone
            ]));
        }else{
            Flash::success(__('generator.all_items_are_deleted'));
        }

        return redirect(route($this->modelName.'.index'));

    }

    protected function batchExportExcel($ids){

        $items = [];
        foreach($ids as $id){
            $item = $this->repository->findWithoutFail($id);
            if (!empty($item)) {
                $items[] = $item;
            }
        }

        return $this->exportItemsToExcel($items);
    }

    private function exportItemsToExcel($items){

        $exportClass = new class($items, $this->fields, $this->excelItems, $this->params[self::NS_CUSTOM_VIEW], $this->modelName, $this->skeleton)
            implements FromView, ShouldAutoSize, WithEvents  {

            protected $items;
            protected $fields;
            protected $excelItems;
            protected $customView;
            protected $modelName;
            protected $skeleton;

            public function __construct($items, $fields, $excelItems, $customView, $modelName, $skeleton){
                $this->items = $items;
                $this->fields = $fields;
                $this->excelItems = $excelItems;
                $this->customView = $customView;
                $this->modelName = $modelName;
                $this->skeleton = $skeleton;
            }

            public function view(): View
            {
                return view($this->skeleton.'.excel')->with([
                    'items'         => $this->items,
                    'fields'        =>  $this->fields,
                    'headerItems'   => $this->excelItems,
                    'customView'    => $this->customView,
                    'modelName'         => $this->modelName,
                    'batchActions'      => [],
                    'objectActions'     => [],
                    'sortField'         => ''
                ]);
            }

            /**
             * @return array
             */
            public function registerEvents(): array
            {
                return [
                      AfterSheet::class    => function(AfterSheet $event) {
                          $cellRange = 'B:Z'; // All headers
                          $event->sheet->getDelegate()->setRightToLeft(true);
                          $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray(array(
                              'font' => [
                                  'name'      =>  'Tahoma',
                                  'size'      =>  10,
                                  'bold'      =>  false,
                                  'color'      =>  [
                                      'rgb' => '000000'
                                  ]
                              ]
                          ));

                          $cellRange = 'A1:Z1'; // All headers
                          $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray(array(
                              'fill'    => [
                                  'fillType' => Fill::FILL_SOLID,
                                  'color'      =>  [
                                      'rgb' => '4286f4'
                                  ]
                              ],
                              'font'    => [
                                  'name'      =>  'Tahoma',
                                  'size'      =>  10,
                                  'bold'      =>  false,
                                  'color'      =>  [
                                      'rgb' => 'FFFFFF'
                                  ]
                              ]
                          ));

                      },
                  ];
            }
        };

        return Excel::download($exportClass, $this->modelName . '.xlsx');

    }

}