// $(document).ready(function () {
//     $(".add_item_btn").click(function (e) {
//         e.preventDefault();
//         $("#show_item").prepend(`  <div class="row">
//         <div class="col-md-3 mb-3">
//      <input type="text" name="medicine_name[]" class="form-control" placeholder="medicine Name">
//         </div>

//         <div class="col-md-3 mb-3">
//             <input type="number" name="medicine_price[]" class="form-control" placeholder="medicine Price">
//                </div>

//                <div class="col-md-3 mb-3">
//                 <input type="number" name="medicine_qty[]" class="form-control" placeholder="medicine quntity">
//                    </div>

//                    <div class="col-md-2 mb-3 d-grid">
//                     <button class="btn btn-danger remove_item_btn">Remove</button>
//                    </div>
//       </div>`);
//     });
//     $(document).on("click", ".remove_item_btn", function (e) {
//         e.preventDefault();
//         let row_item = $(this).parent().parent();
//         $(row_item).remove();
//     });
// });

var btn = document.getElementById("add_item_btn");
var show_item = document.getElementById("show_item");
btn.addEventListener("click", addMedicine);
function addMedicine(e) {
    e.preventDefault();
    var txt = document.getElementById("MedicineName").value;
    console.log(txt);
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
