@extends('layouts.app')


@section('title') Create @endsection

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

<form action="{{route('orders.store')}}" method="POST" enctype="multipart/form-data" id="add_form">
  @csrf
  <div class="mt-4"> 
    <label for="ClientName" class="form-label">Client Name</label>
    <select id="ClientName" onchange="selectAddress()" name="client_name" class="form-control w-50">
        <option name="newMedicine"></option>
        @foreach($clients as $client)
          
            <option value="{{$client}}">{{$client->type->name }} </option>
        @endforeach
    </select>
  </div>
  @role('admin')
  <div class="mt-4 pharmData">
    <label for="PharmacyName" class="form-label">Pharmacy Name</label>
    <select id="PharmacyName"  name="pharmacy_name" class="form-control w-50 pharmSelect" data-medicine ="{{$meds}}">
        <option></option>
        @foreach($pharmacies as $pharmacy)
            <option value="{{$pharmacy->pharmaciesMedicines}}">{{$pharmacy->type->name}}</option>
          
        @endforeach
    </select>
  </div>
  @endrole

  <div id="show_item" >
    {{-- <select id="om" class="form-control">
        <option selected="selected">orange</option>
        <option>white</option>
        <option>purple</option>
      </select> --}}
      @role('admin')
      <div class="row medData">
        <div class="col-md-4 mb-3 mt-3 ">
    
    
     <label for="MedicineName" class="form-label ">Medicine Name</label>
     <select id="MedicineName"  name="medicine_name[]" class="form-control  jqSelect  ">
      
        
     </select>
     @endrole
     @role('pharmacy')
     <div class="row medData">
        <div class="col-md-4 mb-3 mt-3 ">
    
    
     <label for="MedicineName" class="form-label ">Medicine Name</label>
     <select id="MedicineName"  name="medicine_name[]" class="form-control  jqSelect  ">
      
        @foreach($medicines as $medicine)
            <option value="{{$medicine}}">{{$medicine->medicine->name}}</option>
        @endforeach
    </select>
        
        </div>
      @endrole
               <div class="col-md-2 mb-3 mt-3">
                <label for="MedicineQnt" class="form-label">Medicine Quantity</label>
                <input type="number" id="MedicineQnt" name="medicine_qty[]" class="form-control medQty h-50" value="0" min="0"  placeholder="medicine quantity">
                   </div>

                   <div class="col-md-2 mb-3 mt-3">
                    <label for="MedicinePrice" class="form-label">Medicine Price</label>
                    <input type="number" id="MedicinePrice" name="medicine_price[]"  class="form-control medPrice h-50" value="0" min="0" placeholder="medicine price" >
                  </div>

                  <div class="col-md-2 mb-3 mt-3">
                    <label for="TotalPrice" class="form-label">Total Price</label>
                    <input type="number" id="TotalPrice" name="total_price[]"  class="form-control medPrice  h-50" value=0  min="0" placeholder="medicine price" >
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
                  <option ></option>
                  <option value="1">Insured</option>
                  <option value="0">Not Insured</option>
             
           </select>
                
                   </div>
                  </div>


    
    <div class="row">
      <div class="col-md-6 mb-3 mt-3">
            <label for="deliviringaddress" class="form-label">DeliveringAddress</label>
                <select id="deliviringaddress" name="delivering_address" class="form-control" data-address ="{{$addresses}}" >
                  
                 </select>
                                 
      </div>
  </div>




 
    <div>
 
    {{-- <button type="submit" class="btn btn-success">Create</button> --}}
    <input type="submit" value="Order" class="btn btn-success w-25"  id="add_btn">
  </div>
  <div class="mt-5">
 
    {{-- <button type="submit" class="btn btn-success">Create</button> --}}
    
  
    {{-- //{{route('posts.edit', $post['id'])}} --}}
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
        newDiv.innerHTML = `
        @role('admin')
        <div class="row medData">
      <div class="col-md-4 mb-3 mt-3">
    
    <label for="MedicineName" class="form-label ">Medicine Name</label>
    <select id="MedicineName"  name="medicine_name[]" class="form-control  jqSelect">
              
    </select>
    
      </div>
      @endrole
      @role('pharmacy')
     <div class="row medData">
        <div class="col-md-4 mb-3 mt-3 ">
    
    
     <label for="MedicineName" class="form-label ">Medicine Name</label>
     <select id="MedicineName"  name="medicine_name[]" class="form-control  jqSelect  ">
      
        @foreach($medicines as $medicine)
            <option value="{{$medicine}}">{{$medicine->medicine->name}}</option>
        @endforeach
    </select>
        
        </div>
      @endrole
             <div class="col-md-2 mb-3 mt-3">
              <label for="MedicineQnt" class="form-label">Medicine Quantity</label>
              <input type="number" id="MedicineQnt" name="medicine_qty[]" class="form-control medQty h-50" value="0"  min="0" placeholder="medicine quantity">
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


    $(".pharmData").on("change",".pharmSelect",{},function (e){
      let medInPharmacies =  JSON.parse($(this).find(":selected").val());
      var medicines=JSON.parse($(this).attr("data-medicine"));
      $('.jqSelect').html("<option>Choose Medicine</option>")

      for(let i=0 ; i<medInPharmacies.length;i++){
        medicines.forEach(val => {
          if(medInPharmacies[i]['medicine_id']==val['id']){
            var option = $('<option/>');
            console.log(JSON.stringify(medInPharmacies[i]));
        option.attr({ 'value':JSON.stringify(medInPharmacies[i]) }).text(String(val['name']));
        $('.jqSelect').append(option);
          }
          });
      }
     
});
  

    $(".medData").on("change",".jqSelect",{},function(e){
      
      let medprice =  JSON.parse($(this).find(":selected").val()).price;
      console.log(medprice);
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
        let select = document.getElementById('ClientName');
        let deliviringaddress = document.getElementById('deliviringaddress');
        deliviringaddress.innerHTML="<option ></option>";
        let address = deliviringaddress.getAttribute("data-address");
      
        let addresses= JSON.parse(address);
       
         var clientid = JSON.parse(select.value).id;
     

       
         for(let i=0 ; i<addresses.length;i++)
         {
          if(addresses[i].client_id==clientid){
            var option = document.createElement('option'); 
            option.value = addresses[i].id;
            
            option.appendChild(document.createTextNode(addresses[i].street_name));
            
            deliviringaddress.appendChild(option);
          }

         
         }
         
      }


 

    </script>


  




@endsection