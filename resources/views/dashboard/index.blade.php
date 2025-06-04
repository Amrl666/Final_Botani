@extends('layouts.app')

@section('content')
<style>
  .cookieContainer {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: nowrap;
  }

  .cookieCard {
    width: 300px;
    height: 200px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    gap: 20px;
    padding: 20px;
    position: relative;
    overflow: hidden;
    border-radius: 1rem;
    cursor: pointer;
    transition: transform 0.2s ease;
    color: rgb(241, 241, 241);
  }

  .cookieCard:hover {
    transform: scale(1.05);
  }

  .cookieCard::before {
    content: "";
    position: absolute;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    right: -25%;
    top: -25%;
    z-index: 1;
  }

  .cookieHeading {
    font-size: 1.5em;
    font-weight: 600;
    z-index: 2;
  }

  .cookieDescription {
    font-size: 2.5em;
    font-weight: 700;
    z-index: 2;
  }
</style>

<div class="mb-6 px-4">
    <h1 class="text-3xl font-bold text-green-800 mb-4">Dashboard</h1>

    <div class="cookieContainer">
        <!-- Card 1 -->
        <div class="cookieCard" style="background: linear-gradient(to right,rgb(137, 104, 255),rgb(175, 152, 255));">
            <style>
              .cookieCard:nth-child(1)::before {
                background: linear-gradient(to right,rgb(142, 110, 255),rgb(208, 195, 255));
              }
            </style>
            <h2 class="cookieHeading">Jumlah Produk</h2>
            <p class="cookieDescription">18</p>
        </div>

        <!-- Card 2 -->
        <div class="cookieCard" style="background: linear-gradient(to right,rgb(250, 176, 5),rgb(255, 214, 94));">
            <style>
              .cookieCard:nth-child(2)::before {
                background: linear-gradient(to right,rgb(255, 198, 57),rgb(255, 233, 131));
              }
            </style>
            <h2 class="cookieHeading">Jumlah Pesanan</h2>
            <p class="cookieDescription">42</p>
        </div>

        <!-- Card 3 -->
        <div class="cookieCard" style="background: linear-gradient(to right,rgb(59, 130, 246),rgb(147, 197, 253));">
            <style>
              .cookieCard:nth-child(3)::before {
                background: linear-gradient(to right,rgb(147, 197, 253),rgb(191, 219, 254));
              }
            </style>
            <h2 class="cookieHeading">Eduwisata Aktif</h2>
            <p class="cookieDescription">5</p>
        </div>
    </div>
</div>
@endsection
