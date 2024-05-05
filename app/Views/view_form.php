<?php

if (isset($_GET['search_data'])) {
  $search_data = htmlspecialchars($_GET['search_data']);
} else {
  $search_data = '';
}
?>
<style>
  th, td{
    text-align: center;
  }
  .pagination {
    display: flex;
    justify-content: end;
    margin-top: 20px;
  }

  .pagination a {
    padding: 5px 10px;
    margin: 0 5px;
    background-color: #007bff;
    color: #fff;
    border-radius: 3px;
    text-decoration: none;
  }

  .pagination a:hover {
    background-color: #0056b3;
  }

  .pagination .active a {
    background-color: #0056b3;
  }
</style>

<div id="msg"></div>
<div class="container mx-4">
  <div class="d-flex bd-highlight">
    <div class="p-2 w-100 bd-highlight">
    <div class="col-md-6 mb-4">
      <a href="/form" class="btn btn-primary">Add Details</a>
      <button type="submit" class="btn btn-danger mx-4" onclick="deleteRow()">Bulk Delete</button>
    </div>

  </div>
  <div class="p-2 flex-shrink-1 bd-highlight"> <?= $data['pagination_links'] ?></div>
</div>
  <form action="<?= base_url() ?>" method="get">
    <div class="row">

      <div class="col-md-3 mb-4">
      <input type="text" class="form-control" id="search_data" value="<?php if($search_data != '') { echo htmlspecialchars($search_data); } else { echo ''; } ?>" name="search_data" placeholder="Search">
      </div>
      <div class="col-md-3 mb-4">
        <input type="submit" class="btn btn-primary"  value="Search">
   
      </div>
    </div>
  </form>

  
</div>
<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="selectAllCheckbox" value="0">
          <label class="form-check-label" for="selectAllCheckbox"></label>
        </div>
      </th>
      <th>ID</th>
      <th>Name</th>
      <th>company_name</th>
      <th>designation</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>

  <tbody>
    <?php
    $i = 1;
    foreach ($data['items'] as $row) {
    ?>
      <tr>
        <td>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="<?= $row['id'];  ?>" id="check">
            <label class="form-check-label" for="<?= $row['id'];  ?>">
            </label>
          </div>
        </td>
        <!-- <td><?= $i ?></td> -->
        <td><?= $row['id']; ?></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['company_name']; ?></td>
        <td><?= $row['designation']; ?></td>
        <td><?= $row['email']; ?></td>
        <td>
          <button type="button" class="btn btn-primary" onclick="editrecord(<?= $row['id']; ?>)">Edit</button>
          <button type="button" class="btn btn-danger" onclick="deleterecord(<?= $row['id']; ?>)">Delete</button>
        </td>
      </tr>
    <?php
      $i++;
    }
    ?>
  </tbody>

</table>




</div>
<script>
  $(document).ready(function() {
    $('#selectAllCheckbox').on('click', function() {
      var isChecked = $(this).prop('checked');

      $('input[type="checkbox"]').prop('checked', isChecked);
    });
  });

  function editrecord(id) {
    window.location.href = "/Edit?id=" + id;
  }

  function deleterecord(id) {
    $.ajax({
      url: "/Delete",
      type: "post",
      data: {
        id
      },
      success: function(response) {
        response = JSON.parse(response);
        if (response.error == 0) {
          window.location.href = "/";
        } else {
          $("#msg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">failed...!.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        }

      },
    });
  }

  function deleteRow() {
    var checkboxes = $('input[type="checkbox"]:checked');
    var value = checkboxes.map(function() {
      return $(this).val();
    }).get();
    if(value!=''){
     
    $.ajax({
      url: "/BulkDelete",
      type: "post",
      data: {
        values: value
      },
      success: function(response) {
        response = JSON.parse(response);
        if (response.error == 0) {
          window.location.href = "/";
        } else {
          $("#msg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">failed...!.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        }

      },
    });
     
  }
  }
</script>