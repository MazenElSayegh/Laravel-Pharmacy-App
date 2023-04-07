{{-- 
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
@component
@component('mail::button', ['url' => $confirmUrl, 'color' => 'green'])
Confirm Order
@endcomponent

@component('mail::button', ['url' =>$cancelUrl, 'color' => 'red'])
Cancel Order
@endcomponent
@component --}}




@component('mail::message')

Hi, {{ $client->name }}:<br>
Order Details

Pharmacy Name : {{ $pharmacyName }}
<table border="5" cellspacing="3" cellpadding="3">
    <tbody>
      
{{-- @foreach ($medicines as $medicine)
<tr>
<td>{{ $medicine["name"] }} </td>
<td> {{ $medicine["type"] }} </td>
<td>{{ $medicine["price"] }} </td>
</tr>
@endforeach --}}
<tr>
 <td>Medicine Name </td>   
@foreach($medName as $name)

<td>{{ $name }}</td>

@endforeach
</tr>
<tr>
    <td>Medicine Quantity </td>  
@foreach($medQuantity as $quantity)

<td>{{ $quantity }}</td>

@endforeach
</tr>
<tr>
    <td> Medicine Price </td>
@foreach($medPrice as $price)

<td>{{ $price }}</td>

@endforeach
</tr>
<tr aria-colspan="3">
   <td> Total Price :{{ $order->total_price }}</td>
</tr>
</tbody>
</table>
--------------------
--------------------<br>
@component('mail::button', ['url' => $confirmUrl, 'color' => 'green'])
Confirm Order
@endcomponent
@component('mail::button', ['url' =>$cancelUrl, 'color' => 'red'])
Cancel Order
@endcomponent


@endcomponent



  

    
    
   
   
    