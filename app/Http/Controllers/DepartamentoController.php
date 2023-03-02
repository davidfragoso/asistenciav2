<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\Schedule;

use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departments = Department::with('jefe')->paginate(5);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $jefes_departamento = User::role('jefe')->get();
        return view('departments.crear', compact('jefes_departamento'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments,name',
            'description' => 'required',
            'jefe_id' => 'required|exists:users,id',
            'num_empleados' => 'required',

        ]);




        $department = new Department([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'jefe_id' => $request->get('jefe_id'),
            'num_empleados' => $request->get('num_empleados'),

        ]);
        $department->save();

        return redirect()->route('departments.index')->with('success', 'Departamento creado con éxito');
    }

    public function edit(Department $department)
    {
        $jefes = User::whereHas('roles', function ($query) {
            $query->where('name', 'Jefe');
        })->get();

        return view('departments.editar', compact('department', 'jefes'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id,
            'jefe_id' => 'required|exists:users,id',
        ]);

        $department->name = $request->get('name');
        $department->name = $request->get('description');
        $department->jefe_id = $request->get('jefe_id');
        $department->num_empleados = $request->get('num_empleados');
        $department->save();

        return redirect()->route('departments.index')->with('success', 'Departamento actualizado con éxito');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Departamento eliminado con éxito');
    }
}
