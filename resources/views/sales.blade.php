<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page }} {{ config('app.name') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">

    </head>
    <body>
        <div class="container py-3">
            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif
            @php
                date_default_timezone_set('Asia/Jakarta');
            @endphp
            <h5 class="mb-4">Penjualan hari {{ date('D, d M Y') }}</h5>
            <p>Pendapatan : <b>Rp {{ number_format($total,0,',','.') }}</b></p>
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Tambah Pesanan
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog
                {{-- modal-dialog-centered --}}
                ">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pesanan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="" class="w-100">Pilih menu</label>
                                <select name="id_menu" id="" class="form-select">
                                    @foreach ($menu as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="w-100">Jumlah</label>
                                <input type="number" name="qty" value="1" class="form-control">
                            </div>
                            <button class="d-none" id="btn-submit" type="submit"></button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#btn-submit').trigger('click')" class="btn btn-primary">Tambah</button>
                    </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('sales.index') }}" class="d-flex mb-3">
                <div class="form-group me-2">
                    <input type="date" value="{{ isset($_GET['date'] ? $_GET['date']) : date('Y-m-d') }}" class="form-control" name="dateFilter">
                </div>
                <button class="btn btn-primary" type="submit">Filter</button>
            </form>
            <table id="myTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                        <tr>
                            <td>
                                <button type="submit" onclick="alert_confirm('{{ route('sales.destroy',['id' => $value->id]) }}')" class="btn btn-danger">
                                    Del
                                </button>
                            </td>
                            <td>{{ $value->name }}</td>
                            <td>{{ number_format($value->price,0,',','.') }}</td>
                            <td>{{ $value->qty }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready( function () {
                $('#myTable').DataTable({
                    pageLength: 50,
                    lengthMenu: [[5,10, 50, 100, -1], [5, 10, 50, 100, "Semua"]],
                });
                $('#myTable_length').remove();
                $('#myTable_filter').remove();
            });
            function alert_confirm(url){
                Swal.fire({
                    title: 'Hapus data?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                            window.location.href = url;
                    }
                })
            }
        </script>
    </body>
</html>
