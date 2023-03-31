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

<form action="/orders" method="POST" enctype="multipart/form-data" id="add_form">
  @csrf
  <div>
    <label for="ClientName" class="form-label">Client Name</label>
    <select id="ClientName" name="ClientName" class="form-control">
        @foreach($clients as $client)
            <option value="{{$client->id}}">{{$client->name}}</option>
        @endforeach
    </select>
  </div>
  
  <div id="show_item">
    {{-- <select id="om" class="form-control">
        <option selected="selected">orange</option>
        <option>white</option>
        <option>purple</option>
      </select> --}}
      <div class="row">
        <div class="col-md-5 mb-3 mt-3">
     {{-- <input type="text" name="medicine_name[]" class="form-control" placeholder="medicine Name"> --}}
     <label for="MedicineName" class="form-label ">Medicine Name</label>
     <select id="MedicineName" name="medicine_name[]" class="form-control  jqSelect">
            <option ></option>
         @foreach($clients as $client)
             <option value="{{$client->id}}">{{$client->name}}</option>
         @endforeach
     </select>
     
        </div>
               <div class="col-md-5 mb-3 mt-3">
                <label for="MedicineQnt" class="form-label">Medicine Quantity</label>
                <input type="number" id="MedicineQnt" name="medicine_qty[]" class="form-control h-50" placeholder="medicine quantity">
                   </div>

                   <div class="col-md-2 mb-3 mt-5">
                    <button class="btn btn-success " id="add_item_btn">Add More</button>
                   </div>
      </div>
    
  </div>
  <div>
    {{-- <button type="submit" class="btn btn-success">Create</button> --}}
    <input type="submit" value="Store" class="btn btn-success w-25" id="add_btn">
  </div>
  </form>
 

  <script>

    var btn = document.getElementById("add_item_btn");
    var show_item = document.getElementById("show_item");
    btn.addEventListener("click", addMedicine);
    function addMedicine(e) {
        e.preventDefault();
      
        var newDiv = document.createElement("div");
        newDiv.innerHTML = ` <div class="row">
      <div class="col-md-5 mb-3 mt-3">
    
    <label for="MedicineName" class="form-label ">Medicine Name</label>
    <select id="MedicineName" name="medicine_name[]" class="form-control  jqSelect">
          <option ></option>
       @foreach($clients as $client)
           <option value="{{$client->id}}">{{$client->name}}</option>
       @endforeach
    </select>
    
      </div>
             <div class="col-md-5 mb-3 mt-3">
              <label for="MedicineQnt" class="form-label">Medicine Quantity</label>
              <input type="number" id="MedicineQnt" name="medicine_qty[]" class="form-control h-50" placeholder="medicine quantity">
                 </div>
    
                 <div class="col-md-2 mb-3 mt-5">
                    <button class="btn btn-danger remove_item_btn">Remove</button>
                   </div>
    </div>`;
        show_item.appendChild(newDiv);
    $('.jqSelect').select2({
      tags: true
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
    
    </script>


  




@endsection