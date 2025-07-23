<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Register') }} - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .role-selected {
            border-color: #3B82F6 !important;
            background-color: #EFF6FF !important;
        }
        .role-selected.trainer {
            border-color: #F97316 !important;
            background-color: #FFF7ED !important;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex">
        <!-- Left Side - Hero Section -->
        <div class="hidden lg:block relative w-0 flex-1">
            <div class="absolute inset-0 gradient-bg flex items-center justify-center overflow-hidden">
                <!-- Floating Elements -->
                <div class="absolute top-20 right-10 w-20 h-20 bg-white rounded-full opacity-10 floating"></div>
                <div class="absolute bottom-20 left-10 w-32 h-32 bg-white rounded-full opacity-10 floating" style="animation-delay: -1s;"></div>
                <div class="absolute top-1/2 right-1/4 w-16 h-16 bg-white rounded-full opacity-10 floating" style="animation-delay: -2s;"></div>
                
                <div class="text-center text-white px-12">
                    <div class="mb-8">
                        <i class="fas fa-rocket text-8xl mb-6 opacity-80"></i>
                    </div>
                    <h1 class="text-4xl font-bold mb-6">Start Your Fitness Revolution</h1>
                    <p class="text-xl text-purple-100 mb-8 leading-relaxed">
                        Whether you're a fitness enthusiast or a professional trainer, join our community and unlock your potential.
                    </p>
                    
                    <!-- Features -->
                    <div class="space-y-4 max-w-md mx-auto text-left">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-300 mr-3"></i>
                            <span>Connect with certified trainers</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-300 mr-3"></i>
                            <span>Flexible scheduling system</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-300 mr-3"></i>
                            <span>Track your progress</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-300 mr-3"></i>
                            <span>Join a supportive community</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center space-x-3 mb-6">
                        <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center">
                            <i class="fas fa-dumbbell text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold gradient-text">TrainerBook</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Create Account</h2>
                    <p class="mt-2 text-gray-600">Join thousands of fitness enthusiasts today</p>
                </div>

                <form class="space-y-6" action="{{ route('register.submit') }}" method="POST">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-green-600"></i>Full Name
                        </label>
                        <input id="name" name="name" type="text" autocomplete="name" required 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 @error('name') border-red-500 @enderror"
                               placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>Email Address
                        </label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 @error('email') border-red-500 @enderror"
                               placeholder="Enter your email">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-purple-600"></i>Password
                        </label>
                        <div class="relative">
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-300 @error('password') border-red-500 @enderror"
                                   placeholder="Create a strong password">
                            <button type="button" onclick="togglePassword('password', 'password-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-orange-600"></i>Confirm Password
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all duration-300"
                                   placeholder="Confirm your password">
                            <button type="button" onclick="togglePassword('password_confirmation', 'password-confirm-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="password-confirm-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            <i class="fas fa-users mr-2 text-indigo-600"></i>I want to join as:
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="role-option border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition-colors" data-role="client">
                                <input type="radio" name="role" value="client" id="role-client" class="hidden" {{ old('role', 'client') == 'client' ? 'checked' : '' }}>
                                <label for="role-client" class="cursor-pointer">
                                    <div class="text-center">
                                        <i class="fas fa-user text-blue-600 text-2xl mb-2"></i>
                                        <div class="font-semibold text-gray-900">Client</div>
                                        <div class="text-sm text-gray-600">Find trainers</div>
                                    </div>
                                </label>
                            </div>
                            <div class="role-option border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-orange-500 transition-colors" data-role="trainer">
                                <input type="radio" name="role" value="trainer" id="role-trainer" class="hidden" {{ old('role') == 'trainer' ? 'checked' : '' }}>
                                <label for="role-trainer" class="cursor-pointer">
                                    <div class="text-center">
                                        <i class="fas fa-dumbbell text-orange-600 text-2xl mb-2"></i>
                                        <div class="font-semibold text-gray-900">Trainer</div>
                                        <div class="text-sm text-gray-600">Offer services</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white gradient-bg hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-300">
                            <i class="fas fa-user-plus mr-2"></i>
                            Create Account
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                Sign in here
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Handle role selection
        document.addEventListener('DOMContentLoaded', function() {
            const roleOptions = document.querySelectorAll('.role-option');
            const clientRadio = document.getElementById('role-client');
            const trainerRadio = document.getElementById('role-trainer');
            
            function updateRoleSelection() {
                roleOptions.forEach(option => {
                    const role = option.dataset.role;
                    option.classList.remove('role-selected', 'trainer');
                    
                    if ((role === 'client' && clientRadio.checked) || (role === 'trainer' && trainerRadio.checked)) {
                        option.classList.add('role-selected');
                        if (role === 'trainer') {
                            option.classList.add('trainer');
                        }
                    }
                });
            }
            
            roleOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const role = this.dataset.role;
                    if (role === 'client') {
                        clientRadio.checked = true;
                        trainerRadio.checked = false;
                    } else {
                        trainerRadio.checked = true;
                        clientRadio.checked = false;
                    }
                    updateRoleSelection();
                });
            });
            
            // Set initial state
            updateRoleSelection();

            // Add entrance animations
            const form = document.querySelector('form');
            form.style.opacity = '0';
            form.style.transform = 'translateY(20px)';
            form.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                form.style.opacity = '1';
                form.style.transform = 'translateY(0)';
            }, 200);
        });
    </script>
</body>
</html>
