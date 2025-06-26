@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Complete Your Company Onboarding</h2>

    <form action="{{ route('client.onboarding.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-medium" for="name">Company Name</label>
            <input type="text" name="name" id="name" required class="w-full border border-gray-300 px-3 py-2 rounded" />
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium" for="domain">Company Domain</label>
            <input type="text" name="domain" id="domain" placeholder="example.com" required class="w-full border border-gray-300 px-3 py-2 rounded" />
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium" for="branding">Brand Color</label>
            <input type="color" name="branding" id="branding" class="w-16 h-10 border-none" />
        </div>

        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded">
            Submit & Finish
        </button>
    </form>
</div>
@endsection
