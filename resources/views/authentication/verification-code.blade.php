@extends('layout')

@section('title', 'Verification code')

@section('content')


<div class="min-h-screen flex items-center justify-center p-4 bg-gray-100">
  <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Verify Your Account</h2>
    <p class="text-center text-gray-600 mb-6">Enter the 6-digit code sent to your email or phone</p>
    <form class="space-y-4" id="verify-form" method="POST" action="{{ route('verification.submit') }}">
      @csrf
      <div class="flex justify-center space-x-2">
        @for ($i = 0; $i < 6; $i++)
          <input type="text" maxlength="1" name="code[]" class="code-input w-12 h-12 text-center border border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" required>
        @endfor
      </div>
      <button type="submit" id="verify-button" disabled class="w-full bg-gray-400 text-white py-2 rounded-md cursor-not-allowed">Verify</button>
      <p class="text-center text-sm text-gray-600 mt-4">Didn't receive the code? 
        <a href="{{ route('verification.resend') }}" class="text-blue-600 hover:underline">Resend Code</a>
      </p>
    </form>
  </div>
</div>
@endsection








@section('scripts')
<script>
  const inputs = document.querySelectorAll('.code-input');
  const button = document.getElementById('verify-button');

  function checkInputsFilled() {
    const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
    button.disabled = !allFilled;
    button.classList.toggle('cursor-not-allowed', !allFilled);
    button.classList.toggle('bg-blue-400', !allFilled);
    button.classList.toggle('bg-blue-600', allFilled);
    button.classList.toggle('hover:bg-blue-700', allFilled);
  }

  inputs.forEach(input => {
    input.addEventListener('input', checkInputsFilled);
  });
</script>
@endsection
