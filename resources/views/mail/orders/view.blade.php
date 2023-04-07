
@component('mail::message')

Hi, {{ $client->name }}:<br>
Order Details
<table border="5" cellspacing="3" cellpadding="3">
    <tbody>
        <tr>
            <td> Name  </td>
            <td> Medicine Type  </td>
            <td> Medicine Price  </td>
            </tr> 
@foreach ($medicines as $medicine)
<tr>
<td>{{ $medicine["name"] }} </td>
<td> {{ $medicine["type"] }} </td>
<td> {{ $medicine["price"] }} </td>
</tr>
@endforeach
</tbody>
</table>
--------------------Total Price :{{ $order->total_price }}
--------------------<br>
@component('mail::button', ['url' => $url, 'color' => 'blue'])
Confirm Order
@endcomponent

@component('mail::button', ['url' =>'', 'color' => 'blue'])
Cancel Order
@endcomponent




  

    
    
   
   
    