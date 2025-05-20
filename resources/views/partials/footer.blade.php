<footer class="bg-white pt-8">
    {{-- CTA Atas Footer --}}
    <div class="px-6 md:px-16 lg:px-24 mb-10">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 text-left">
            KAMI HADIR UNTUK <span class="text-green-600">KALIAN!</span>
        </h2>
        <p class="text-gray-700 mb-6 text-left">
            Memberikan Solusi tepat untuk memajukan kelompok tani winongo asri
        </p>

        <div class="text-left max-w-xl">
            <ul class="space-y-3 text-gray-700">
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                    <span>Efisiensi adalah <span class="text-green-600 font-semibold">kunci</span></span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                    <span>Aplikasi yang <span class="text-green-600 font-semibold">mudah diakses</span></span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                    <span>Penanganan yang <span class="text-green-600 font-semibold">cepat</span></span>
                </li>
            </ul>
        </div>
    </div>


    {{-- Footer Sosial --}}
    <div class="bg-lime-300 py-6  rounded-t-2xl">
    <div class="container mx-auto flex flex-col md:flex-row md:justify-between items-start gap-4">
        
        {{-- Logo + Nama --}}
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo/logobotani.png') }}" alt="BO TANI Logo" class="w-12 h-12">
            <span class="text-2xl font-bold text-green-800">BO TANI</span>
        </div>

        {{-- Copyright --}}
        <div class="text-sm text-white mt-2 md:mt-0">
            ©{{ date('Y') }} | <span class="font-bold">BO <span class="text-lime-800">TANI</span></span> | All Rights Reserved
        </div>

        {{-- Sosial Media --}}
        <div class="flex space-x-4 mt-2 md:mt-0">
            <a href="#" class="text-white hover:text-lime-700">
                <i class="fab fa-facebook-square text-2xl"></i>
            </a>
            <a href="#" class="text-white hover:text-lime-700">
                <i class="fab fa-instagram text-2xl"></i>
            </a>
            <a href="#" class="text-white hover:text-lime-700">
                <i class="fab fa-youtube text-2xl"></i>
            </a>
        </div>
    </div>
</div>

</footer>
