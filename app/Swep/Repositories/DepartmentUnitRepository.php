<?php

namespace App\Swep\Repositories;
 
use App\Swep\BaseClasses\BaseRepository;
use App\Swep\Interfaces\DepartmentUnitInterface;


use App\Models\DepartmentUnit;


class DepartmentUnitRepository extends BaseRepository implements DepartmentUnitInterface {
	


    protected $department_unit;



	public function __construct(DepartmentUnit $department_unit){

        $this->department_unit = $department_unit;
        parent::__construct();

    }






    public function fetchAll($request){

       $key = str_slug($request->fullUrl(), '_');

        $department_units = $this->cache->remember('department_units:all:' . $key, 240, function() use ($request){

            $department_unit = $this->department_unit->newQuery();
            
            if(isset($request->q)){
                $this->search($department_unit, $request->q);
            }

            return $this->populate($department_unit);

        });

        return $department_units;

    }






    public function store($request){

        $department_unit = new DepartmentUnit;
        $department_unit->slug = $this->str->random(16);
        $department_unit->department_unit_id = $this->getDepartmentUnitIdInc();
        $department_unit->department_id = $request->department_id;
        $department_unit->department_name = $request->department_name;
        $department_unit->name = $request->name;
        $department_unit->description = $request->description;
        $department_unit->created_at = $this->carbon->now();
        $department_unit->updated_at = $this->carbon->now();
        $department_unit->ip_created = request()->ip();
        $department_unit->ip_updated = request()->ip();
        $department_unit->user_created = $this->auth->user()->user_id;
        $department_unit->user_updated = $this->auth->user()->user_id;
        $department_unit->save();

        return $department_unit;

    }






    public function update($request, $slug){

        $department_unit = $this->findBySlug($slug);
        $department_unit->department_id = $request->department_id;
        $department_unit->department_name = $request->department_name;
        $department_unit->name = $request->name;
        $department_unit->description = $request->description;
        $department_unit->updated_at = $this->carbon->now();
        $department_unit->ip_updated = request()->ip();
        $department_unit->user_updated = $this->auth->user()->user_id;
        $department_unit->save();
        
        return $department_unit;

    }





    public function destroy($slug){

        $department_unit = $this->findBySlug($slug);
        $department_unit->delete();
        
        return $department_unit;

    }






    public function findBySlug($slug){

        $department_unit = $this->cache->remember('department_units:bySlug:' . $slug, 240, function() use ($slug){
            return $this->department_unit->where('slug', $slug)->first();
        });
        
        if(empty($department_unit)){
            abort(404);
        }
        
        return $department_unit;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('department_name', 'LIKE', '%'. $key .'%')
                      ->orwhere('name', 'LIKE', '%'. $key .'%')
                      ->orwhere('description', 'LIKE', '%'. $key .'%');
        });

    }






    public function populate($model){

        return $model->select('name', 'department_name', 'description', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate(10);

    }
    





    public function getDepartmentUnitIdInc(){

        $id = 'DU1001';

        $department_unit = $this->department_unit->select('department_unit_id')->orderBy('department_unit_id', 'desc')->first();

        if($department_unit != null){

            if($department_unit->department_unit_id != null){
                $num = str_replace('DU', '', $department_unit->department_unit_id) + 1;
                $id = 'DU' . $num;
            }
        
        }
        
        return $id;
        
    }







    public function globalFetchAll(){

        $department_units = $this->cache->remember('department_units:global:all', 240, function(){
            return $this->department_unit->select('name', 'department_unit_id', 'description')->get();
        });
        
        return $department_units;
    }







    public function apiGetByDepartmentName($dept_name){

        $department_unit = $this->cache->remember('api:department_units:byDepartmentName:'. $dept_name .'', 240, function() use ($dept_name){

            return $this->department_unit->select('name', 'department_unit_id', 'description')
                                         ->where('department_name', $dept_name)
                                         ->get();

        });     

        return $department_unit;

    }







    public function apiGetByDepartmentId($dept_id){

        $department_unit = $this->cache->remember('api:department_units:byDepartmentId:'. $dept_id .'', 240, function() use ($dept_id){

            return $this->department_unit->select('name', 'department_unit_id', 'description')
                                         ->where('department_id', $dept_id)
                                         ->get();

        });     

        return $department_unit;

    }







}