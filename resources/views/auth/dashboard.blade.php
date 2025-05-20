@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard Admin</h1>

    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Produk</h3>
                    <p>Kelola Produk</p>
                </div>
                <div class="icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <a href="{{ route('products.index') }}" class="small-box-footer">Kelola <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Berita</h3>
                    <p>Kelola Berita</p>
                </div>
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <a href="{{ route('news.index') }}" class="small-box-footer">Kelola <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Edu Wisata</h3>
                    <p>Kelola Paket Edu</p>
                </div>
                <div class="icon">
                    <i class="fas fa-school"></i>
                </div>
                <a href="{{ route('edu-wisata.index') }}" class="small-box-footer">Kelola <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

</div>
@endsection
