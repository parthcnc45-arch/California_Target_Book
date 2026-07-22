@extends('layouts.email')

@section('content')

<h1>California Target Book</h1>

<p>
  Hello {{ $classified->first_name }},
</p>
<p>
  Thank you for submitting your classified ad on California Target Book.
  Your payment of <strong>${{ number_format($classified->rate_amount, 2) }}</strong> was successful.
</p>
<p class="mb-xl">
  Your Ad is currently <strong>Pending</strong> review. It will be published within 1 business day upon approval.
</p>

<table class="table table-striped" style="width: 100%; text-align: left; border-collapse: collapse; margin-top: 20px; border: 1px solid #ddd;">
  <thead style="background-color: #f8f9fa;">
    <tr>
      <th style="border-bottom: 2px solid #ddd; padding: 12px;">Ad Headline</th>
      <th style="border-bottom: 2px solid #ddd; padding: 12px;">Category</th>
      <th style="border-bottom: 2px solid #ddd; padding: 12px;">Cost</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding: 12px; border-bottom: 1px solid #eee;">{{ $classified->title }}</td>
      <td style="padding: 12px; border-bottom: 1px solid #eee;">{{ ucfirst($classified->category) }}</td>
      <td style="padding: 12px; border-bottom: 1px solid #eee;">${{ number_format($classified->rate_amount, 2) }}</td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="2" style="text-align: right; padding: 12px;">Total Paid</th>
      <th style="padding: 12px; font-size: 1.1em;">${{ number_format($classified->rate_amount, 2) }}</th>
    </tr>
  </tfoot>
</table>

<div style="margin-top: 20px; padding: 15px; background-color: #f8fafc; border-radius: 5px; border-left: 4px solid #3182ce;">
  <strong>Payment ID:</strong> {{ $charge->id ?? 'N/A' }}<br>
  <strong>Date:</strong> {{ date('F j, Y') }}<br>
  <strong>Duration:</strong> {{ \Carbon\Carbon::parse($classified->starts_on)->format('m/d/Y') }} to {{ \Carbon\Carbon::parse($classified->ends_on)->format('m/d/Y') }}
</div>

<p style="margin-top: 30px; font-size: 0.9em; color: #666;">
    If you have any questions about your ad or this receipt, please contact us at info@californiatargetbook.com.
</p>

@endsection
