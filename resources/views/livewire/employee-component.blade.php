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
        <form wire:submit.prevent='submit'>
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
                    <button type="button" class="btn btn-primary" wire:click='store' name="submit">SIMPAN</button>
                </div>
            </div>
        </form>
    </div>
    <!-- AKHIR FORM -->

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Data Pegawai</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-md-1">No</th>
                    <th class="col-md-4">Nama</th>
                    <th class="col-md-3">Email</th>
                    <th class="col-md-2">Alamat</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($collection as $item) --}}
                <tr>
                    <td>1</td>
                    <td>Muhammad</td>
                    <td>muhammad@gmail.com</td>
                    <td>Yogyakarta</td>
                    <td>
                        <a href="" class="btn btn-warning btn-sm">Edit</a>
                        <a href="" class="btn btn-danger btn-sm">Del</a>
                    </td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>

    </div>
    <!-- AKHIR DATA -->
</div>
