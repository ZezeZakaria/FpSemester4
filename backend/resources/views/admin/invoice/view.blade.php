@extends('admin.dashboard.master')
@section('main-content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Invoice No.</th>
                            <th>Pembeli</th>
                            <th>Alamat</th>
                            <th>Tanggal</th>
                            <th>Detail</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $item->invoice_number }}
                                </td>
                                <td>
                                    {{ $item->user->name }}
                                </td>
                                <td>
                                    {{ $item->user->address ?? '' }}
                                </td>
                                <td>
                                    {{ $item->created_at->format('Y-M-d') }}
                                </td>
                                <td>
                                    <ol>
                                        @foreach ($item->details as $d)
                                            <li>
                                                {{ $d->product->product_name }} x{{ $d->quantity }}
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td>
                                    @php
                                        $amount = collect($item->details)->reduce(function (?int $carry, $item) {
                                            return $carry + $item->quantity * $item->price;
                                        });
                                    @endphp
                                    {{ number_format($amount) }}
                                </td>
                                <td>
                                    @if ($item->payment_file)
                                        <a href="{{ url('storage/' . $item->payment_file) }}" target="blank">
                                            Lihat bukti bayar
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->status }}
                                </td>
                                <td>
                                    @if ($item->status == 'on-check')
                                        <a href="{{ route('invoice.judgement', ['id' => $item->id, 'judgement' => 'OK']) }}"
                                            class="btn btn-success btn-sm">
                                            Terima
                                        </a>
                                        <a href="{{ route('invoice.judgement', ['id' => $item->id, 'judgement' => 'NOT-OK']) }}"
                                            class="btn btn-danger btn-sm">
                                            Tolak
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#datatable").DataTable();
        })
    </script>
@endsection
