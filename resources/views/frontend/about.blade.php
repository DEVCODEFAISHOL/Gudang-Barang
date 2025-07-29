@extends('layouts.frontend')

@section('title', 'About Us - YourBrand')

@section('content')
<!-- Hero Section -->
<section class="gradient-bg py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-fade-in text-white">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">About Us</h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto">
                Mengenal lebih dekat tentang perjalanan, visi, dan misi kami dalam memberikan yang terbaik untuk Anda
            </p>
        </div>
    </div>
</section>

<!-- Company Story -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in">
                <div class="h-96 bg-gradient-to-br from-blue-100 to-purple-100 rounded-3xl flex items-center justify-center">
                    <i class="fas fa-building text-6xl text-gray-400"></i>
                </div>
            </div>
            <div class="animate-fade-in">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Our Story</h2>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    Didirikan pada tahun 2020, YourBrand dimulai dari mimpi sederhana untuk menyediakan produk berkualitas tinggi dengan harga yang terjangkau untuk semua kalangan.
                </p>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    Kami percaya bahwa setiap orang berhak mendapatkan produk terbaik tanpa harus mengorbankan kualitas. Dengan dedikasi dan kerja keras, kami telah melayani ribuan pelanggan di seluruh Indonesia.
                </p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center p-4 bg-blue-50 rounded-xl">
                        <div class="text-3xl font-bold text-blue-600 mb-1">5+</div>
                        <div class="text-sm text-gray-600">Years Experience</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-xl">
                        <div class="text-3xl font-bold text-purple-600 mb-1">1000+</div>
                        <div class="text-sm text-gray-600">Happy Customers</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Vision & Mission</h2>
            <p class="text-xl text-gray-600">Komitmen kami untuk masa depan yang lebih baik</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="card-hover bg-white p-8 rounded-2xl shadow-lg">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-eye text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi platform e-commerce terdepan di Indonesia yang memberikan pengalaman berbelanja terbaik dengan menyediakan produk berkualitas tinggi, pelayanan prima, dan inovasi berkelanjutan untuk meningkatkan kualitas hidup masyarakat.
                </p>
            </div>

            <div class="card-hover bg-white p-8 rounded-2xl shadow-lg">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-bullseye text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed">
                    Menyediakan produk berkualitas dengan harga terjangkau, memberikan pelayanan pelanggan yang excellent, membangun kepercayaan melalui transparansi, dan terus berinovasi untuk memenuhi kebutuhan pelanggan yang berkembang.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Core Values</h2>
            <p class="text-xl text-gray-600">Nilai-nilai fundamental yang memandu setiap langkah kami</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center card-hover p-6">
                <div class="w-20 h-20 bg-gradient-to-r from-red-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Customer First</h3>
                <p class="text-gray-600 text-sm">
                    Kepuasan pelanggan adalah prioritas utama dalam setiap keputusan yang kami buat.
                </p>
            </div>

            <div class="text-center card-hover p-6">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-handshake text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Integrity</h3>
                <p class="text-gray-600 text-sm">
                    Kami berkomitmen untuk selalu jujur dan transparan dalam setiap transaksi.
                </p>
            </div>

            <div class="text-center card-hover p-6">
                <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-star text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Excellence</h3>
                <p class="text-gray-600 text-sm">
                    Kami selalu berusaha memberikan yang terbaik dalam produk dan layanan.
                </p>
            </div>

            <div class="text-center card-hover p-6">
                <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-violet-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-lightbulb text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Innovation</h3>
                <p class="text-gray-600 text-sm">
                    Kami terus berinovasi untuk menghadirkan solusi terdepan bagi pelanggan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
            <p class="text-xl text-gray-600">Tim profesional yang berdedikasi untuk kesuksesan Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @for($i = 1; $i <= 6; $i++)
            <div class="card-hover bg-white rounded-2xl shadow-lg overflow-hidden text-center">
                <div class="h-64 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                    <i class="fas fa-user-circle text-6xl text-gray-400"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Team Member {{ $i }}</h3>
                    <p class="text-purple-600 font-medium mb-3">{{ ['CEO', 'CTO', 'Marketing Director', 'Product Manager', 'Customer Service Lead', 'Operations Manager'][($i-1)] }}</p>
                    <p class="text-gray-600 text-sm mb-4">
                        Experienced professional with {{ 5 + $i }} years in the industry, dedicated to delivering excellence.
                    </p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition duration-300">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition duration-300">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Achievements -->
<section class="py-20 gradient-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-4">Our Achievements</h2>
            <p class="text-xl text-gray-200">Pencapaian yang membanggakan sepanjang perjalanan kami</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center text-white">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trophy text-2xl"></i>
                </div>
                <div class="text-3xl font-bold mb-2">15+</div>
                <div class="text-lg text-gray-200">Awards Won</div>
            </div>

            <div class="text-center text-white">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="text-3xl font-bold mb-2">10K+</div>
                <div class="text-lg text-gray-200">Active Users</div>
            </div>

            <div class="text-center text-white">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shipping-fast text-2xl"></i>
                </div>
                <div class="text-3xl font-bold mb-2">50K+</div>
                <div class="text-lg text-gray-200">Orders Delivered</div>
            </div>

            <div class="text-center text-white">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe text-2xl"></i>
                </div>
                <div class="text-3xl font-bold mb-2">100+</div>
                <div class="text-lg text-gray-200">Cities Covered</div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-gray-900 mb-6">Join Our Journey</h2>
        <p class="text-xl text-gray-600 mb-8">
            Bergabunglah dengan ribuan pelanggan yang telah mempercayai kami sebagai partner terbaik
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('katalog.index') }}"
               class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-4 rounded-full font-semibold hover:from-blue-600 hover:to-purple-700 transition duration-300 transform hover:scale-105">
                <i class="fas fa-shopping-cart mr-2"></i> Start Shopping
            </a>
            <a href="{{ route('contact') }}"
               class="border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-full font-semibold hover:border-purple-500 hover:text-purple-600 transition duration-300">
                <i class="fas fa-phone mr-2"></i> Contact Us
            </a>
        </div>
    </div>
</section>
@endsection
