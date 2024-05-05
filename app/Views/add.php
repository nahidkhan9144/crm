<div id="email_error"></div>
<div class="conatiner bg-light text-dark" style="border: 2px solid #c7baba ; padding: 17px 4px 16px 25px; background-color: #dbe5ef !important;">
  <h5>Add</h5>
<div class="row">
<div class="col-md-4">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name">
  </div>
  <div class="col-md-4">
    <label for="company_name" class="form-label">Company Name</label>
    <input type="text" class="form-control" id="company_name">
  </div>
</div>
<div class="row my-4">
  <div class="col-md-4">
    <label for="desg" class="form-label">Designation</label>
    <input type="text" class="form-control" id="desg">
  </div>
  <div class="col-md-4">
    <label for="email" class="form-label">Email address</label>
    <input type="text" class="form-control" id="email">
  </div>
</div>
  <div class="d-flex justify-content-end col-md-8">
      <button type="submit" class="btn btn-primary my-2" onclick="submit()">Submit</button>
  </div>
</div>
<script>
    function submit(){
      var name = $("#name").val();
      var company_name = $("#company_name").val();
      var desg = $("#desg").val();
      var email = $("#email").val();
      $('#email').on('input', function() {
        email_valid();
      });
      if(name!='' && company_name!='' && desg!='' && email_valid()){
        $("#msg").html("");
       $.ajax({
              url: "/addData",
              type: "post",
              data: {name,company_name,desg,email} ,
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
