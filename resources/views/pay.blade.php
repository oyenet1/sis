@extends('layouts.dashboard')
@section('content')
  <form id="paymentForm">
    <div class="form-group">
      <label for="email">Email Address</label>
      <input type="email" id="email-address" required />
    </div>
    <div class="form-group">
      <label for="amount">Amount</label>
      <input type="tel" id="amount" required />
    </div>
    <div class="form-group">
      <label for="first-name">First Name</label>
      <input type="text" id="first-name" />
    </div>
    <div class="form-group">
      <label for="last-name">Last Name</label>
      <input type="text" id="last-name" />
    </div>
    <div class="form-submit">
      <button type="submit" onclick="payWithPaystack(e)"> Pay </button>
    </div>
  </form>
@endsection
