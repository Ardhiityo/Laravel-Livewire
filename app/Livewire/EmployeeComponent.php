<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;

class EmployeeComponent extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $search;
    public $address;
    public $sortColumn = 'name';
    public $sortDirection = 'asc';
    public $employeeId;
    public $isUpdate = false;
    public $selectedEmployees = [];
    protected $paginationTheme = 'bootstrap';


    public function store()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'address' => 'required|min:3'
        ];

        $validated = $this->validate($rules);

        Employee::create($validated);

        $this->clear();

        session()->flash('notes', 'Berhasil dibuat');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);

        $this->name = $employee->name;
        $this->email = $employee->email;
        $this->address = $employee->address;

        $this->isUpdate = true;

        $this->employeeId = $id;
    }

    public function update()
    {
        $employee = Employee::findOrFail($this->employeeId);

        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'address' => 'required|min:3'
        ];

        $validated = $this->validate($rules);

        $employee->update($validated);

        $this->clear();

        session()->flash('notes', 'Berhasil diperbarui');
    }

    public function deleteConfirm($id)
    {
        if ($id) {
            $this->employeeId = $id;
        } else {
            $this->employeeId = null;
        }
    }

    public function delete()
    {
        if ($this->employeeId) {
            $employee = Employee::findOrFail($this->employeeId);
            $employee->delete();
        } else {
            Employee::destroy($this->selectedEmployees);
        }

        $this->clear();

        session()->flash('notes', 'Berhasil dihapus');
    }

    public function clear()
    {
        $this->name = '';
        $this->email = '';
        $this->address = '';
        $this->isUpdate = false;
        $this->employeeId = null;
        $this->selectedEmployees = [];
    }

    public function sortable($column)
    {
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        if ($this->search) {
            $employees = Employee::whereLike('name', '%' . $this->search . '%')
                ->orWhereLike('email', '%' . $this->search . '%')
                ->orWhereLike('address', '%' . $this->search . '%')
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate(2);
        } else {
            $employees = Employee::orderBy($this->sortColumn, $this->sortDirection)
                ->paginate(2);
        }

        return view('livewire.employee-component', compact('employees'));
    }
}
