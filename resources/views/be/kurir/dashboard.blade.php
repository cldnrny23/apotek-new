@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Page Title Header Starts-->
    <div class="row page-title-header">
      <div class="col-12">
        <div class="page-header">
          <h4 class="page-title">Dashboard Kurir</h4>
        </div>
      </div>
    </div>
    <!-- Page Title Header Ends-->

    <!-- Statistics Cards -->
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-3 col-md-6">
                <div class="d-flex">
                  <div class="wrapper">
                    <h3 class="mb-0 font-weight-semibold">{{ $total_pengiriman }}</h3>
                    <h5 class="mb-0 font-weight-medium text-primary">Total Pengiriman</h5>
                  </div>
                  <div class="wrapper my-auto ml-auto ml-lg-4">
                    <i class="mdi mdi-package-box" style="font-size: 2rem; color: #007bff;"></i>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                <div class="d-flex">
                  <div class="wrapper">
                    <h3 class="mb-0 font-weight-semibold">{{ $sedang_dikirim }}</h3>
                    <h5 class="mb-0 font-weight-medium text-warning">Sedang Dikirim</h5>
                  </div>
                  <div class="wrapper my-auto ml-auto ml-lg-4">
                    <i class="mdi mdi-truck" style="font-size: 2rem; color: #ffc107;"></i>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                <div class="d-flex">
                  <div class="wrapper">
                    <h3 class="mb-0 font-weight-semibold">{{ $tiba_ditujuan }}</h3>
                    <h5 class="mb-0 font-weight-medium text-success">Diterima</h5>
                  </div>
                  <div class="wrapper my-auto ml-auto ml-lg-4">
                    <i class="mdi mdi-check-circle" style="font-size: 2rem; color: #28a745;"></i>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                <div class="d-flex">
                  <div class="wrapper">
                    <h3 class="mb-0 font-weight-semibold">{{ auth()->user()->name }}</h3>
                    <h5 class="mb-0 font-weight-medium text-info">Nama Kurir</h5>
                  </div>
                  <div class="wrapper my-auto ml-auto ml-lg-4">
                    <i class="mdi mdi-account" style="font-size: 2rem; color: #17a2b8;"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pengiriman Table -->
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Daftar Pengiriman Anda</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Pelanggan</th>
                    <th>Tanggal Kirim</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($pengirimans as $pengiriman)
                  <tr>
                    <td>{{ ($pengirimans->currentPage() - 1) * $pengirimans->perPage() + $loop->iteration }}</td>
                    <td>{{ $pengiriman->no_invoice }}</td>
                    <td>{{ $pengiriman->penjualan->pelanggan->nama_pelanggan ?? '-' }}</td>
                    <td>{{ $pengiriman->tgl_kirim ? \Carbon\Carbon::parse($pengiriman->tgl_kirim)->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                      @if($pengiriman->status_kirim === 'Diterima')
                        <label class="badge badge-success">{{ $pengiriman->status_kirim }}</label>
                      @else
                        <label class="badge badge-warning">{{ $pengiriman->status_kirim }}</label>
                      @endif
                    </td>
                    <td>{{ $pengiriman->keterangan ?? '-' }}</td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada pengiriman</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            @if($pengirimans->hasPages())
              <div class="d-flex justify-content-center">
                {{ $pengirimans->links() }}
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
