@extends('layout')

@section('title', 'Login')

@section('body-class', "min-h-screen flex items-center justify-center p-4")

@section('content')
<div class="flex items-center justify-center min-h-screen p-4">
  <div class=" rounded-lg max-w-5xl w-full p-6 md:p-10 flex flex-col md:flex-row gap-8"
    style="background-image: url('https://res-console.cloudinary.com/dvurjw1nd/thumbnails/v1/image/upload/v1747305003/YmFjay1pbWdfZmZ1Ym40/drilldown'); background-size: cover; background-position: center;">

  {{-- IMAGE --}}
  <div class="w-full md:w-1/2 flex justify-center items-center me-24">
    <img
      src="https://www.winktaxi.com/assets/images/Winktaxi-taxi-agadir.webp"
      alt="Registration"
      class="rounded-lg w-full h-auto object-cover max-h-[500px]">
  </div>

  {{-- FORM --}}
  <div class="w-full md:w-1/2 space-y-6">
    <div class="text-center">
      <h2 class="text-blue-600 text-2xl font-bold">Log In To Your Account</h2>
      <p class="text-gray-500 text-sm mt-2">We'll send you a verification code to confirm your identity</p>
    </div>

    {{-- FORM --}}
    <form id="register-form" class="space-y-5">
      {{-- Input --}}
      <div>
        <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Phone Number or Email *</label>
        <div class="flex gap-3">
          <select id="countrycode" required class="border border-gray-300 rounded-lg px-2 py-2.5 text-sm hidden transition-all">
            <option value="+212">+212 (MA)</option>
            <option value="+1">+1 (US)</option>
            <option value="+44">+44 (UK)</option>
            <option value="+91">+91 (IN)</option>
          </select>
          <input type="text" id="login" placeholder="email@example.com or 0606060606" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm transition-all">
        </div>
      </div>

      {{-- Terms --}}
      <div class="flex items-center">
        <input type="checkbox" id="terms" class="mr-2 h-4 w-4 text-blue-600">
        <label for="terms" class="text-sm text-gray-700">I accept the <a href="#" class="text-blue-500 hover:underline">terms of use</a> and <a href="#" class="text-blue-500 hover:underline">privacy policy</a></label>
      </div>

      {{-- Buttons --}}
      <div class="space-y-3">
        <button type="button" id="get-email-code" class="w-full py-2.5 rounded-lg bg-gray-300 text-gray-600 text-sm font-medium cursor-not-allowed" disabled>Get Code via Email</button>
        <button type="button" id="get-sms-code" class="w-full py-2.5 rounded-lg bg-gray-300 text-gray-600 text-sm font-medium cursor-not-allowed hidden" disabled>Get Code via SMS</button>
        <button type="button" id="get-whatsapp-code" class="w-full py-2.5 rounded-lg bg-gray-300 text-gray-600 text-sm font-medium cursor-not-allowed hidden" disabled>Get Code via WhatsApp</button>
      </div>

    {{-- Social Login --}}
      <div class="flex flex-col sm:flex-row gap-3 mt-4">
        <button type="button" class="flex items-center justify-center gap-2 flex-1 py-2.5 px-4 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium">
          <iconify-icon icon="logos:google-icon" width="20" height="20"></iconify-icon> with Google
        </button>
        <button type="button" class="flex items-center justify-center gap-2 flex-1 py-2.5 px-4 bg-black hover:bg-gray-800 text-white rounded-lg text-sm font-medium">
          <iconify-icon icon="ic:baseline-apple" width="20" height="20"></iconify-icon> with Apple
        </button>
      </div>

      <div>
        <button type="button" id="qr-button" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">
          <iconify-icon icon="material-symbols:qr-code-scanner" width="20" height="20"></iconify-icon> Log in with QR Code
        </button>
      </div>

      <p class="text-center text-gray-500 text-sm pt-2">Create new account? <a href="/register" class="text-blue-500 hover:underline font-medium">Sign Up</a></p>
    </form>
  </div>
</div>
</div>



{{-- Hidden Section Of QR Code --}}

{{-- QR Modal --}}
<div id="qr-modal" class="hidden fixed inset-0 z-40 bg-black/80 flex justify-center items-center">
  <div class="relative p-6 rounded-lg shadow-lg max-w-sm w-full z-50 bg-white">
    <button id="close-qr" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
      <iconify-icon icon="mdi:close" width="24" height="24"></iconify-icon>
    </button>
    <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Scan QR Code to Login</h3>
    <div class="flex justify-center">
      <img src="https://www.winktaxi.com/assets/images/QR-3.png" alt="QR Code" class="w-full max-w-xs h-auto rounded-md" />
    </div>
    <p class="mt-4 text-sm text-gray-500 text-center">Open your mobile app and scan this code to log in instantly</p>
  </div>
</div>
@endsection


@vite('.resources/js/winkScript.js')


