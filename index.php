<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <title>Searchable Table</title>
</head>
<body>
  <div class="container my-5">
    <h1 class="text-center">Searchable Table</h1>
   
    <table class="table table-bordered" id="dataTable">
             <div class="row">
                    <div class="col-sm-8"> <input class="form-control mb-3" id="myInput" type="text" placeholder="Search.."></div>
                    <div class="col-sm-4">
                        <button type="button" id="getData" onclick="updateTable()" class="btn btn-info add-new"><i class="fa fa-plus"></i> Get Data</button>
                    </div>
</div>

                </div>
    </table>

  <!-- Section: Images -->
    <button class="btn btn-info add-new" id="openModalButton">Open Modal</button>

<div id="imageModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Image Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <p><button class="btn btn-outline-primary" id="selectImageButton">Select Image</button></p>
    <div id="selectedImageContainer"></div>
  </div>

  </div>
</div>


  
<!-- Modal gallery -->
<script>
const table = document.querySelector("#dataTable");

  function updateTable() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "API_func.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);
      
      // Clear the existing table
      while (table.firstChild) {
        table.removeChild(table.firstChild);
      }
      
      // Write the data to the table
      const thead = document.createElement("thead");
      table.appendChild(thead);
      
      const headers = Object.keys(data[0]);
      const desiredValues = ['task', 'title', 'description', 'colorCode'];
      const tr = document.createElement("tr");
      headers.forEach(header => {
        if (desiredValues.includes(header)) {
        const th = document.createElement("th");
        th.textContent = header;
        tr.appendChild(th);
      }
      });
      thead.appendChild(tr);
      
      const tbody = document.createElement("tbody");
      tbody.setAttribute("id", "myTable");
      table.appendChild(tbody);
      
      data.forEach(row => {
        const tr = document.createElement("tr");
        headers.forEach(header => {
           if (desiredValues.includes(header)) {
          const td = document.createElement("td");
          if (desiredValues.includes('colorCode')) {
            td.style.color = row[header];
          }
           td.textContent = row[header]; 
          tr.appendChild(td);
        }
        });
        tbody.appendChild(tr);
      });
    }
  };
  xhr.send();
};

setInterval(updateTable, 60 * 60 * 1000);

// Get the modal and button elements
var modal = document.getElementById("imageModal");
var openModalButton = document.getElementById("openModalButton");
var close = document.getElementsByClassName("close")[0];
var selectImageButton = document.getElementById("selectImageButton");
var selectedImageContainer = document.getElementById("selectedImageContainer");

// Open the modal when the button is clicked
openModalButton.addEventListener("click", function() {
  modal.style.display = "block";
});

// Close the modal when the close span is clicked
close.addEventListener("click", function() {
  modal.style.display = "none";
});

// Select and display an image when the select image button is clicked
selectImageButton.addEventListener("click", function() {
  var fileInput = document.createElement("input");
  fileInput.type = "file";
  fileInput.accept = "image/*";
  fileInput.click();
  fileInput.addEventListener("change", function() {
    var selectedImage = fileInput.files[0];
    var reader = new FileReader();
    reader.addEventListener("load", function() {
      selectedImageContainer.innerHTML = "";
      var image = new Image();
      image.src = reader.result;
      selectedImageContainer.appendChild(image);
    });
    reader.readAsDataURL(selectedImage);
  });
});

</script>
  </div>
  <script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
</body>
</html>

