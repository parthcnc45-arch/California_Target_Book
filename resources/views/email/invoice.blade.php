@extends('layouts.email')

@section('content')

<h1>California Target Book</h1>

<p>
  Hello {{$name}},
</p>
<p>
  The following is a summary of your purchase from
  The California Target Book.
</p>
<p class="mb-xl">
  Your invoice ID is
  <span class="text-red">{{ $invoiceNumber }}</span>.
</p>

<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Description</th>
      <th>Cost</th>
    </tr>
  </thead>

  <tbody>
    @foreach($line_items as $li)
    <tr>
      <th>{{ $li->quantity }}</th>
      <td>{{ $li->description }}</td>
      <td>${{ $li->amount / 100 }}</td>
    </tr>
    @endforeach

  </tbody>

  <tfoot>
    <tr>
      <th></th>
      <th>Total</th>
      <th>${{ $total / 100 }}</th>
    </tr>
  </tfoot>

</table>


@endsection
