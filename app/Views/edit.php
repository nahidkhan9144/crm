
<div id="email_error"></div>
<div class="col-md-8">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" value = "<?php echo $data->name ?>" id="name">
    <input type="hidden" class="form-control" value = "<?php echo $data->id ?>" id="id">
  </div>
  <div class="col-md-8">
    <label for="company_name" class="form-label">Company Name</label>
    <input type="text" class="form-control" value = "<?php echo $data->company_name ?>" id="company_name">
  </div>
  <div class="col-md-8">
    <label for="desg" class="form-label">Designation</label>
    <input type="text" class="form-control" value = "<?php echo $data->designation ?>" id="desg">
  </div>
  <div class="col-md-8">
    <label for="email" class="form-label">Email address</label>
    <input type="text" class="form-control" value = "<?php echo $data->email ?>" id="email">
  </div>
  <div class="d-flex justify-content-end col-md-8">
      <button type="submit" class="btn btn-primary my-2" onclick="update()">Update</button>
  </div>

<script>
    function update(){
      var id = $("#id").val();
      var name = $("#name").val();
      var company_name = $("#company_name").val();
      var desg = $("#desg").val();
      var email = $("#email").val();
      $('#email').on('input', function() {
        email_valid();
      });
      if(!email_valid()){
        return;
      }
      if(name!='' && company_name!='' && desg!=''){
        $("#msg").html("");
       $.ajax({
              url: "/update",
              type: "post",
              data: {id,name,company_name,desg,email} ,
              success: function (response) {
                response = JSON.parse(response);
            if(response.error==0){
                window.location.href="/";
                }
            else{
                $("#msg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">failed...!.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                }
              },
          });
        }else{
            $("#msg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">Please Fill All Required Fields!.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        }
    }
    function email_valid(){
      var email = $("#email").val();
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(regex.test(email)){
          $("#email_error").html('');
          return true;
        }else{
          $("#email_error").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">Please Enter Valid Email Address!.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
          return false;
        }
    }
</script>
