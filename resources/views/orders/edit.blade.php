@extends('layouts.app')


@section('title') edit @endsection

@section('content')

@if ($errors->any())
<br>
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{route('orders.update',$order->id)}}" method="POST" enctype="multipart/form-data" id="add_form">
  @csrf
  @method ("PUT")
  <div class="mt-4"> 
    <label for="ClientName" class="form-label">Client Name</label>
    <select id="ClientName" name="client_name" class="form-control w-50" data-order ="{{$order}}" >
        <option value="{{$client}}" >{{$client->type->name }} </option>
        
        {{-- @foreach($clients as $client)
          
            <option value="{{$client}}">{{$client->type->name }} </option>
        @endforeach --}}
    </select>
  </div>
  
  @role('admin')
  @if($order->creator_type=="pharmacy") 
  <div class="mt-4">
    <label for="PharmacyName" class="form-label">Pharmacy Name</label>
    <select id="PharmacyName"  name="pharmacy_name" class="form-control w-50">
        <option></option>
        @foreach($pharmacies as $pharmacy)
            <option value="{{$pharmacy->id}}">{{$pharmacy->type->name}}</option>
        @endforeach
    </select>
  </div>
  @endif
  @endrole
  @if(auth()->user()->hasRole('admin' | 'pharmacy'))
  
  @if($order->creator_type=="doctor") 

  <div class="mt-4">
    <label for="DoctorName" class="form-label">Doctor Name</label>
    <select id="DoctorName"  name="doctor_name" class="form-control w-50">
        <option></option>
        @foreach($doctors as $doctor)
            <option value="{{$doctor->id}}">{{$doctor->type->name}}</option>
        @endforeach
    </select>
  </div>
  @endif
  @endif


  <div id="show_item" >
    {{-- <select id="om" class="form-control">
        <option selected="selected">orange</option>
        <option>white</option>
        <option>purple</option>
      </select> --}}
      <div class="row medData">
        <div class="col-md-4 mb-3 mt-3 ">
    
    
     <label for="MedicineName" class="form-label ">Medicine Name</label>
     <select id="MedicineName"  name="medicine_name[]" class="form-control  jqSelect  ">
            <option  ></option>
         @foreach($medicines as $medicine)
             <option    value="{{$medicine}}">{{$medicine->medicine->name}}</option>
         @endforeach
     </select>
     
        </div>
               <div class="col-md-2 mb-3 mt-3">
                <label for="MedicineQnt" class="form-label">Medicine Quantity</label>
                <input type="number" id="MedicineQnt" name="medicine_qty[]" class="form-control medQty h-50" value="0" min="0" placeholder="medicine quantity">
                   </div>

                   <div class="col-md-2 mb-3 mt-3">
                    <label for="MedicinePrice" class="form-label">Medicine Price</label>
                    <input type="number" id="MedicinePrice" name="medicine_price[]"  class="form-control medPrice h-50" value="0" min="0" placeholder="medicine price" >
                  </div>

                  <div class="col-md-2 mb-3 mt-3">
                    <label for="TotalPrice" class="form-label">Total Price</label>
                    <input type="number" id="TotalPrice" name="total_price[]"  class="form-control medPrice  h-50" value=0 min="0" placeholder="medicine price" >
                       </div>

                  

                   <div class="col-md-2 mb-3 mt-5">
                    <button class="btn btn-success " id="add_item_btn">Add New Medicine</button>
                   </div>
      </div>
    
  </div>

  <div class="row">
 <div class="col-md-6 mb-3 mt-3">
                <label for="OrderTotalPrice" class="form-label">Is Insured</label>
                <select id="isinsured" name="is_insured" class="form-control">
                  @if($order->is_insured)
                  <option value="1" selected>Insured</option>
                  @else
                  <option value="0" selected>Not Insured</option>
                  @endif
           </select>
                
                   </div>
</div>

{{-- 
@if($order->creator_type!="client")     --}}
    <div class="row">
      <div class="col-md-6 mb-3 mt-3">
            <label for="deliviringaddress" class="form-label">DeliviringAddress</label>
                <select id="deliviringaddress" name="delivering_address" class="form-control" data-address ="{{$addresses}}"  >
                  
                 </select>
                                 
      </div>
  </div>
{{-- @endif --}}




 
    <div>
 
    {{-- <button type="submit" class="btn btn-success">Create</button> --}}
    <input type="submit" value="update" class="btn btn-success w-25"  id="add_btn">
  </div>

  
  
  </form>
   
  {{-- <form action="{{route('payments.checkout',['id'=>$id])}}" method="post">
    @csrf
   
    <button  class="btn btn-primary">Check Out</button>
</form> --}}

  <script>
 var ob =document.getElementById("MedicineName");
 var o =document.getElementById("MedicineQnt");
   var OrderTotalPrice =document.getElementById("OrderTotalPrice");
    var btn = document.getElementById("add_item_btn");
    var show_item = document.getElementById("show_item");
    btn.addEventListener("click", addMedicine);
    function addMedicine(e) {
        e.preventDefault();
      
        var newDiv = document.createElement("div");        
        newDiv.innerHTML = ` <div class="row medData">
      <div class="col-md-4 mb-3 mt-3">
    
    <label for="MedicineName" class="form-label ">Medicine Name</label>
    <select id="MedicineName"  name="medicine_name[]" class="form-control  jqSelect">
          <option ></option>
          @foreach($medicines as $medicine)
             <option value="{{$medicine}}">{{$medicine->medicine->name}}</option>
         @endforeach
    </select>
    
      </div>
             <div class="col-md-2 mb-3 mt-3">
              <label for="MedicineQnt" class="form-label">Medicine Quantity</label>
              <input type="number" id="MedicineQnt" name="medicine_qty[]" class="form-control medQty h-50" value=0 min="0" placeholder="medicine quantity">
                 </div>

                 <div class="col-md-2 mb-3 mt-3">
                    <label for="MedicinePrice" class="form-label">Medicine Price</label>
                    <input type="number" id="MedicinePrice" name="medicine_price[]"  class="form-control medPrice  h-50" value=0 min="0" placeholder="medicine price" >
                       </div>

                       <div class="col-md-2 mb-3 mt-3">
                    <label for="TotalPrice" class="form-label">Total Price</label>
                    <input type="number" id="TotalPrice" name="total_price[]"  class="form-control medPrice  h-50" value=0 min="0" placeholder="medicine price" >
                       </div>
    
                 <div class="col-md-2 mb-3 mt-5">
                    <button class="btn btn-danger remove_item_btn">Remove</button>
                   </div>
    </div>`;
        show_item.appendChild(newDiv);
    $('.jqSelect').select2({
      tags: true,
      placeholder: "Select a medicine name",
    
    });
  

    $(".medData").on("change",".jqSelect",{},function(e){
      let medprice =  JSON.parse($(this).find(":selected").val()).price;
      let medqty= $(this).parent().next().children(':first-child').next().val();
    let total_price = Number(medqty)*Number(medprice);
    
   $(this).parent().next().next().children(':first-child').next().val(medprice);
   $(this).parent().next().next().next().children(':first-child').next().val(total_price);

});

$(".medData").on("change",".medQty",{},function(e){
  var medqty =  JSON.parse($(this).val());
    let medprice =$(this).parent().next().children(':first-child').next().val();
    let total_price = Number(medqty)*Number(medprice);
    $(this).parent().next().next().children(':first-child').next().val(total_price);
});

    }
    
    document.addEventListener("click", deleteMedicine);
    function deleteMedicine(e) {
        let tar = e.target;
        if (e.target.classList.contains("remove_item_btn")) {
            e.preventDefault();
            let inptxt = tar.parentElement.parentElement;
            inptxt.remove();
        }
    }


    // document.addEventListener("change", getTotalPrice);
    // function getTotalPrice(e) {
    //     let tar = e.target.value;
    //     if (e.target.classList.contains("medQty") || e.target.classList.contains("jqSelect")) {
    //         e.preventDefault();
          
    //        let medPrice = document.getElementById("MedicinePrice").value;
    //         let total_price = Number(tar)*Number(medPrice);
    //         console.log(total_price);
    //     }
    // }
    
      
     
      
      function selectAddress(){
        console.log("hi")
        let select = document.getElementById('ClientName');
        let deliviringaddress = document.getElementById('deliviringaddress');
        // deliviringaddress.innerHTML="<option ></option>";
        let address = deliviringaddress.getAttribute("data-address");
        let order = select.getAttribute("data-order");
        let addresses= JSON.parse(address);
        let orderAddressId=JSON.parse(order).address_id;
        console.log(orderAddressId);
         var clientid = JSON.parse(select.value).id;
          console.log(clientid);

       
         for(let i=0 ; i<addresses.length;i++)
         {
          if(addresses[i].client_id==clientid && addresses[i].id == orderAddressId ){
            var option = document.createElement('option'); 
            option.value = addresses[i].id;
            
            option.appendChild(document.createTextNode(addresses[i].street_name));
            
            deliviringaddress.appendChild(option);
          }

         
         }
         
      }


 

    </script>


  




@endsection