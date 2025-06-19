<?php

namespace App\Livewire;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeComponent extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $address;
    public $employeeId;
    public $isUpdate = false;
    public $search;
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
        $this->employeeId = $id;
    }

    public function delete()
    {
        $employee = Employee::findOrFail($this->employeeId);
        $employee->delete();

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
    }

    public function render()
    {
        $employees = Employee::orderByDesc('id')->paginate(5);

        if ($this->search) {
            $employees = Employee::whereLike('name', '%' . $this->search . '%')
                ->orWhereLike('email', '%' . $this->search . '%')
                ->orWhereLike('address', '%' . $this->search . '%')
                ->orderByDesc('id')
                ->paginate(5);
        } else {
            $employees = Employee::orderByDesc('id')->paginate(5);
        }

        return view('livewire.employee-component', compact('employees'));
    }
}
