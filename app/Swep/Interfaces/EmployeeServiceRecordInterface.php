<?php

namespace App\Swep\Interfaces;
 


interface EmployeeServiceRecordInterface {

	public function fetchByEmpNo($slug);

	public function store($request, $slug);

	public function update($request, $slug);

	public function destroy($slug);

	public function getBySlug($slug);

}