<div class="container">
    <!-- START FORM -->
    @if ($errors->any())
        <div class="p-3 mt-2 rounded bg-white">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="alert alert-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('notes'))
        <div class="p-3 mt-2 rounded bg-white d-flex align-items-center">
            <h4>{{ session('notes') }}</h4>
        </div>
    @endif

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <form>
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model='name'>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" wire:model='email'>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model='address'>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    @if ($isUpdate)
                        <button type="button" class="btn btn-primary" wire:click='update'
                            name="submit">UPDATE</button>
                        <button type="button" class="btn btn-secondary" wire:click='clear'
                            name="submit">CLEAR</button>
                    @else
                        <button type="button" class="btn btn-primary" wire:click='store' name="submit">SIMPAN</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <!-- AKHIR FORM -->

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Data Pegawai</h1>
        <div class="my-3 d-flex justify-content-end">
            <input type="text" class="form-control w-25" placeholder="Cari pegawai..." wire:model.live='search'>
        </div>
        <div class="my-3 d-flex {{ !empty($selectedEmployees) ? 'justify-content-between' : 'justify-content-end' }}">
            @if (!empty($selectedEmployees))
                <div>
                    <button class="btn btn-danger" wire:click="deleteConfirm('')" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Hapus {{ count($selectedEmployees) }}
                        data
                    </button>
                </div>
            @endif
            <div>
                {{ $employees->links() }}
            </div>
            <div>
                {{ $sortDirection }}
                {{ $sortColumn }}
            </div>
        </div>
        <table class="table table-striped table-sortable">
            <thead>
                <tr>
                    <th></th>
                    <th class="col-md-1">No</th>
                    <th class="col-md-4 sort @if ($sortColumn === 'name') {{ $sortDirection }} @endif"
                        wire:click="sortable('name')">Nama</th>
                    <th class="col-md-3 sort @if ($sortColumn === 'email') {{ $sortDirection }} @endif"
                        wire:click="sortable('email')">Email</th>
                    <th class="col-md-2 sort @if ($sortColumn === 'address') {{ $sortDirection }} @endif"
                        wire:click="sortable('address')">Alamat</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $key => $employee)
                    <tr>
                        <td>
                            <input type="checkbox" wire:key='{{ $employee->id }}' wire:model.live='selectedEmployees'
                                value="{{ $employee->id }}">
                        </td>
                        <td>{{ $employees->firstItem() + $key }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->address }}</td>
                        <td>
                            <button wire:click='edit({{ $employee->id }})' class="btn btn-warning btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                wire:click='deleteConfirm({{ $employee->id }})'>Del</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <!-- AKHIR DATA -->

    {{-- Modal --}}
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin untuk menghapus data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click='delete'
                        data-bs-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal --}}

</div>
