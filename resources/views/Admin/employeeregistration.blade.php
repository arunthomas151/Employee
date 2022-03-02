<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employee Management | Registration</title>
  @include('Includes.header')
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
@include('Includes.adminmenu')
<div class="content-wrapper">
    <div class="content-header">  
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Employee Registration</h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <form class="addform" id="addform" enctype="multipart/form-data">
                <h2>Employee Details</h2>
                <div class="form-group">

                    <label>Employee Name</label>
                    <input type="text" required class="form-control" id="employee_name" name="employee_name">
                </div>
                <div class="form-group">
                    <label>Employee Email</label>
                    <input type="text" required class="form-control" id="employee_email" name="employee_email">
                </div>
                <div class="form-group">
                    <label>Employee Image</label>
                    <input type="file" required class="form-control" id="employee_image" name="employee_image">
                </div>
                <div class="form-group">
                    <label>Employee Designation</label>
                    <select type="text" required class="form-control" id="designation_id" name="designation_id">
                        <option value="" selected disabled>Select One</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->designation_id }}">{{ $designation->designation_name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="button" id="save" class="btn btn-primary">Save</button>
                <a href="{{route('employeelist')}}"><button type="button" id="save" class="btn btn-danger">Cancel</button></a>

                </form>
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
      </div>
      </div>
        
      </div>
    </section>
  </div>
</div>
@include('Includes.footer')
</body>
</html>
<script>
    toastr.options = {
    "closeButton": true,
    "newestOnTop": true,
    "positionClass": "toast-top-right"
    };
    $('#save').on('click', function() {
        var formData = new FormData($('#addform')[0]);
        formData.append("_token", '{{csrf_token()}}');
        $.ajax({
            type: "post",
            url: "{{ route('add_employee') }}",
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(res) {
                if (res.status == 201) {
                    document.getElementById("addform").reset();
                    toastr.success(res.message);
                } else {
                    toastr.error(res.message);
                }
            }
        });
    });
</script>