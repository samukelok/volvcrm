@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8">
        <!-- Logo and Header -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                Complete Your Setup
            </h2>
            <p class="mt-2 text-gray-600">Just a few more details to get your VolvCRM account ready</p>
        </div>

        <!-- Progress Indicator -->
        <div class="bg-white/60 backdrop-blur-xl border border-white/20 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-600">Setup Progress</span>
                <span class="text-sm font-medium text-blue-600">Step 2 of 2</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-2 rounded-full transition-all duration-300" style="width: 100%"></div>
            </div>
        </div>

        <!-- Onboarding Form -->
        <div class="bg-white/80 backdrop-blur-xl border border-white/20 shadow-2xl rounded-2xl p-8">
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('info') }}
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('client.onboarding.store') }}" class="space-y-6">
                @csrf

                <!-- Company Information Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m4 0V9a2 2 0 011-1h4a2 2 0 011 1v12m-6 0h6"></path>
                            </svg>
                            Company Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Tell us about your business</p>
                    </div>

                    <div>
                        <label for="brand_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Company Name *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m4 0V9a2 2 0 011-1h4a2 2 0 011 1v12m-6 0h6"></path>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="brand_name" 
                                name="brand_name" 
                                value="{{ old('brand_name') }}"
                                required 
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                placeholder="e.g., Solar Solutions Co"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">This will be displayed on your funnels and communications</p>
                    </div>

                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                            Website URL
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                </svg>
                            </div>
                            <input 
                                type="url" 
                                id="website" 
                                name="website" 
                                value="{{ old('website') }}" 
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                placeholder="https://yourcompany.com"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Your main business website</p>
                    </div>






                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                            Company Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                </svg>
                            </div>
                            <input 
                                type="email" 
                                id="company_email" 
                                name="company_email" 
                                value="{{ old('website') }}"
                                 
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                placeholder="support@yourcompany.com"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Your company email address for enquiries</p>
                    </div>
                </div>

                <!-- Branding Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                            </svg>
                            Brand Customization
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Customize the look and feel of your funnels</p>
                    </div>

                    <div>
                        <label for="branding" class="block text-sm font-medium text-gray-700 mb-2">
                            Primary Brand Color
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input 
                                    type="color" 
                                    id="branding_color" 
                                    name="branding" 
                                    value="{{ old('branding', '#4e73df') }}"
                                    class="h-12 w-20 border border-gray-300 rounded-xl cursor-pointer"
                                >
                            </div>
                            <div class="flex-1">
                                <input 
                                    type="text" 
                                    id="branding_text" 
                                    name="branding_text" 
                                    value="{{ old('branding', '#4e73df') }}"
                                    placeholder="#4e73df"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                >
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">This color will be used for buttons, links, and accents in your funnels</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Complete Setup & Start Building Funnels
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- What's Next Section -->
        <div class="bg-gradient-to-r from-blue-50/80 to-purple-50/80 backdrop-blur-xl border border-white/20 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                What's Next?
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-semibold text-sm">1</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Request Your First Funnel</h4>
                        <p class="text-sm text-gray-600">Tell us about your goals and target audience</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-purple-600 font-semibold text-sm">2</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">We Build It For You</h4>
                        <p class="text-sm text-gray-600">Our team creates your custom landing page</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-green-600 font-semibold text-sm">3</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Start Capturing Leads</h4>
                        <p class="text-sm text-gray-600">Your funnel goes live and starts generating results</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} VolvCRM. All rights reserved.</p>
        </div>
    </div>
</div>

<script>
// Sync color picker with text input
document.addEventListener('DOMContentLoaded', function() {
    const colorPicker = document.getElementById('branding_color');
    const textInput = document.getElementById('branding_text');
    const companyEmailInput = document.getElementById('company_email');

    companyEmailInput.addEventListener('input', function() {
        // Update the hidden input that actually gets submitted
        document.querySelector('input[name="company_email"]').value = this.value;
    });
    
    // Update text input when color picker changes
    colorPicker.addEventListener('input', function() {
        textInput.value = this.value;
        // Update the hidden input that actually gets submitted
        document.querySelector('input[name="branding"]').value = this.value;
    });
    
    // Update color picker when text input changes
    textInput.addEventListener('input', function() {
        if (this.value.match(/^#[0-9A-F]{6}$/i)) {
            colorPicker.value = this.value;
            document.querySelector('input[name="branding"]').value = this.value;
        }
    });
    
    // Initialize values
    textInput.value = colorPicker.value;
});
</script>
@endsection