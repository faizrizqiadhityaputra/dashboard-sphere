@extends('layouts.sphere')

@section('title', 'SPHERE — Analisis Geospasial Multitemporal')
@section('body_class', 'sphere-app sphere-page-geospasial')
@section('meta_description', 'SPHERE - Perbandingan geospasial multitemporal NDVI, suhu permukaan, dan tekanan ekologis Kabupaten Merauke tahun 2023–2026.')

@section('content')

<!-- SUBHEADER & BREADCRUMB -->
<section class="context-subheader">
    <div class="container-fluid px-4">
        <div class="row align-items-center gy-2">
            <div class="col-12 col-md-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-sphere m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ringkasan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Geospasial</li>
                    </ol>
                </nav>
                <h1 class="page-title m-0">Analisis Geospasial</h1>
                <div class="page-subtitle">
                    Perbandingan NDVI, suhu permukaan (LST), dan tekanan ekologis tahun 2023–2026.
                </div>
            </div>
            <div class="col-12 col-md-5 text-md-end">
                <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                    <div class="input-group input-group-sm" style="width: 175px;">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-crosshair"></i></span>
                        <select class="form-select border-start-0 ps-0" id="geoAoiSelect">
                            <option value="cluster-3" selected>Merauke — Klaster 3</option>
                            <option value="cluster-1">Merauke — Klaster 1</option>
                            <option value="cluster-2">Merauke — Klaster 2</option>
                        </select>
                    </div>
                    <button class="btn btn-sm btn-outline-primary btn-export-trigger d-flex align-items-center gap-1.5" data-format="GeoJSON Vektor" title="Ekspor format spasial GeoJSON">
                        <i class="bi bi-filetype-json"></i>
                        <span>Ekspor GeoJSON</span>
                    </button>
                    <button class="btn btn-sm btn-primary btn-export-trigger d-flex align-items-center gap-1.5" data-format="Hasil Analisis CSV" title="Unduh tabel hasil analisis spasial">
                        <i class="bi bi-download"></i>
                        <span>Unduh Hasil Analisis</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KONTEN UTAMA HALAMAN GEOSPASIAL -->
<div class="container-fluid px-4 py-3">
    <div class="row g-3">

        <div class="col-12">
            <div class="card p-3 h-100 d-flex flex-column">
                @include('partials.unified-map-modern', [
                    'mapPrefix' => 'geo',
                    'mapContainerId' => 'geoMap'
                ])
            </div>
        </div>


    </div>
</div>

@endsection

@push('scripts')
@include('partials.map-scripts')
@endpush
