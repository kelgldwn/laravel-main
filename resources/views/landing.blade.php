<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrainerBook - Find Your Perfect Fitness Trainer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans overflow-x-hidden">
    
    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center">
                        <i class="fas fa-dumbbell text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold gradient-text">TrainerBook</span>
                </div>
                
                <nav class="hidden md:flex space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-purple-600 transition-colors font-medium">Features</a>
                    <a href="#trainers" class="text-gray-600 hover:text-purple-600 transition-colors font-medium">Trainers</a>
                    <a href="#pricing" class="text-gray-600 hover:text-purple-600 transition-colors font-medium">Pricing</a>
                </nav>

                <div class="flex items-center space-x-4">
                    @auth
                        @php $role = Auth::user()->getRoleNames()->first(); @endphp
                        @if ($role === 'trainer')
                            <a href="{{ route('trainer.dashboard') }}" class="gradient-bg text-white px-6 py-3 rounded-full hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-tachometer-alt mr-2"></i>Trainer Dashboard
                            </a>
                        @elseif ($role === 'client')
                            <a href="{{ route('dashboard') }}" class="gradient-bg text-white px-6 py-3 rounded-full hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-user mr-2"></i>Client Dashboard
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="gradient-bg text-white px-6 py-3 rounded-full hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-home mr-2"></i>Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-600 font-medium transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="gradient-bg text-white px-6 py-3 rounded-full hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            Get Started Free
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 gradient-bg opacity-10"></div>
        <div class="absolute top-20 left-10 w-20 h-20 bg-purple-300 rounded-full opacity-20 floating"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-blue-300 rounded-full opacity-20 floating" style="animation-delay: -1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-pink-300 rounded-full opacity-20 floating" style="animation-delay: -2s;"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center relative z-10">
            <div class="mb-8">
                <span class="inline-block bg-gradient-to-r from-purple-100 to-blue-100 text-purple-800 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    🔥 #1 Trainer Booking Platform
                </span>
            </div>
            
            <h1 class="text-6xl md:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                Transform Your Body,
                <span class="gradient-text block">Elevate Your Life</span>
            </h1>
            
            <p class="text-xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                Connect with world-class certified trainers, book personalized sessions, and achieve extraordinary results with our revolutionary fitness platform.
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-bold gradient-text mb-2">500+</div>
                    <div class="text-gray-600">Expert Trainers</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold gradient-text mb-2">50K+</div>
                    <div class="text-gray-600">Success Stories</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold gradient-text mb-2">4.9★</div>
                    <div class="text-gray-600">Average Rating</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold gradient-text mb-2">24/7</div>
                    <div class="text-gray-600">Support</div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                @auth
                    @php $role = Auth::user()->getRoleNames()->first(); @endphp
                    @if ($role === 'trainer')
                        <a href="{{ route('trainer.dashboard') }}" class="gradient-bg text-white px-10 py-4 rounded-full text-lg font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105 pulse-animation">
                            <i class="fas fa-rocket mr-3"></i>Launch Trainer Dashboard
                        </a>
                    @elseif ($role === 'client')
                        <a href="{{ route('dashboard') }}" class="gradient-bg text-white px-10 py-4 rounded-full text-lg font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105 pulse-animation">
                            <i class="fas fa-fire mr-3"></i>Start Your Journey
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="gradient-bg text-white px-10 py-4 rounded-full text-lg font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105 pulse-animation">
                            <i class="fas fa-bolt mr-3"></i>Enter Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="gradient-bg text-white px-10 py-4 rounded-full text-lg font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105 pulse-animation">
                        <i class="fas fa-rocket mr-3"></i>Start Free Today
                    </a>
                    <a href="{{ route('login') }}" class="bg-white text-purple-600 px-10 py-4 rounded-full text-lg font-semibold border-2 border-purple-200 hover:border-purple-400 hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-sign-in-alt mr-3"></i>Sign In
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-gray-900 mb-6">Why TrainerBook Rocks</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Experience the future of fitness with cutting-edge features designed for your success</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="card-hover bg-gradient-to-br from-purple-50 to-blue-50 p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Smart Scheduling</h3>
                    <p class="text-gray-600">AI-powered booking system that finds the perfect time slots for you and your trainer</p>
                </div>

                <div class="card-hover bg-gradient-to-br from-green-50 to-teal-50 p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-medal text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Elite Trainers</h3>
                    <p class="text-gray-600">Hand-picked certified professionals with proven track records of transforming lives</p>
                </div>

                <div class="card-hover bg-gradient-to-br from-orange-50 to-red-50 p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile First</h3>
                    <p class="text-gray-600">Book, track, and manage everything from your phone with our lightning-fast app</p>
                </div>

                <div class="card-hover bg-gradient-to-br from-pink-50 to-purple-50 p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Progress Tracking</h3>
                    <p class="text-gray-600">Advanced analytics and insights to monitor your fitness journey and celebrate wins</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-gray-900 mb-6">Get Started in 3 Easy Steps</h2>
                <p class="text-xl text-gray-600">Your fitness transformation is just minutes away</p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 pulse-animation">
                        <span class="text-3xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Discover Your Trainer</h3>
                    <p class="text-gray-600 text-lg">Browse through hundreds of certified trainers, read reviews, and find your perfect fitness match</p>
                    <div class="absolute top-12 -right-6 hidden md:block">
                        <i class="fas fa-arrow-right text-purple-300 text-3xl"></i>
                    </div>
                </div>

                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 pulse-animation" style="animation-delay: -0.5s;">
                        <span class="text-3xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Book Instantly</h3>
                    <p class="text-gray-600 text-lg">Choose your preferred time, location, and training style. Secure your spot with one click</p>
                    <div class="absolute top-12 -right-6 hidden md:block">
                        <i class="fas fa-arrow-right text-purple-300 text-3xl"></i>
                    </div>
                </div>

                <div class="text-center">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 pulse-animation" style="animation-delay: -1s;">
                        <span class="text-3xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Transform Yourself</h3>
                    <p class="text-gray-600 text-lg">Start your personalized training journey and watch your body and confidence soar</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full opacity-10 floating"></div>
        <div class="absolute bottom-10 right-10 w-24 h-24 bg-white rounded-full opacity-10 floating" style="animation-delay: -1s;"></div>
        
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-5xl font-bold text-white mb-6">Ready to Unleash Your Potential?</h2>
            <p class="text-xl text-purple-100 mb-12 leading-relaxed">
                Join thousands of success stories and start your incredible transformation today. Your future self will thank you.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                @auth
                    @php $role = Auth::user()->getRoleNames()->first(); @endphp
                    @if ($role === 'trainer')
                        <a href="{{ route('trainer.dashboard') }}" class="bg-white text-purple-600 px-10 py-4 rounded-full text-lg font-bold hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-crown mr-3"></i>Access Trainer Hub
                        </a>
                    @elseif ($role === 'client')
                        <a href="{{ route('dashboard') }}" class="bg-white text-purple-600 px-10 py-4 rounded-full text-lg font-bold hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-fire mr-3"></i>Begin Transformation
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bg-white text-purple-600 px-10 py-4 rounded-full text-lg font-bold hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-rocket mr-3"></i>Launch Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="bg-white text-purple-600 px-10 py-4 rounded-full text-lg font-bold hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-star mr-3"></i>Start Free Trial
                    </a>
                    <a href="#features" class="border-2 border-white text-white px-10 py-4 rounded-full text-lg font-bold hover:bg-white hover:text-purple-600 transition-all duration-300">
                        <i class="fas fa-play mr-3"></i>Watch Demo
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center">
                            <i class="fas fa-dumbbell text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold">TrainerBook</span>
                    </div>
                    <p class="text-gray-400 mb-6">Revolutionizing fitness through technology and human connection.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-lg mb-6">For Clients</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-search mr-2"></i>Find Trainers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-calendar mr-2"></i>Book Sessions</a></li>
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chart-line mr-2"></i>Track Progress</a></li>
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-mobile-alt mr-2"></i>Mobile App</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-lg mb-6">For Trainers</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-user-plus mr-2"></i>Join Platform</a></li>
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-calendar-check mr-2"></i>Manage Bookings</a></li>
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-dollar-sign mr-2"></i>Earn More</a></li>
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-graduation-cap mr-2"></i>Training Resources</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-lg mb-6">Support</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-question-circle mr-2"></i>Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-envelope mr-2"></i>Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-shield-alt mr-2"></i>Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-file-contract mr-2"></i>Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2024 TrainerBook. All rights reserved. Made with <i class="fas fa-heart text-red-500"></i> for fitness enthusiasts worldwide.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add scroll effect to header
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('bg-white', 'shadow-xl');
            } else {
                header.classList.remove('shadow-xl');
            }
        });
    </script>
</body>
</html>