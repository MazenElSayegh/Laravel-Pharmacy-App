
@component('mail::message')

Hi, {{ $client->name }}:<br>
Order Details
<table border="5" cellspacing="3" cellpadding="3">
    <tbody>
        <tr>
            <td> Medicine Name </td>
            <td> Medicine Type </td>
            <td> Medicine Price</td>
        </tr> 
@foreach ($medicines as $medicine)
<tr>
<td>{{ $medicine["name"] }} </td>
<td> {{ $medicine["type"] }} </td>
<td>{{ $medicine["price"] }} </td>
</tr>
@endforeach
</tbody>
</table>
--------------------Total Price :{{ $order->total_price }}
--------------------<br>
@component('mail::button', ['url' => $url, 'color' => 'blue'])
Confirm Order
@endcomponent
@component('mail::button', ['url' => $url, 'color' => 'red'])
Cancel Order
@endcomponent


@endcomponent

{{-- <form method="POST" action="/{{$company_id}}/user/{{$user_id}}" accept-charset="UTF-8">
    <input type="hidden" name="_method" value="PUT" />
    <input type="submit" value="Acceptere invitationen fra {{$company}}">
  </form> --}}

  <form action="{{ $url }}" method="POST" enctype="multipart/form-data" id="add_form">
    @csrf
    
    <input type="submit" value=" click to confirm">
  </form>

    
    
    {{-- <td><a class="button button-{{ $color or 'blue' }}" href="{{ $url }}" target="_blank" rel="noopener">{{ $slot }}</a></td> --}}
    
   
    