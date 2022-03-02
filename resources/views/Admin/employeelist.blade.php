<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employee Management | Details</title>
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
            <h1 class="m-0">Employee List</h1>
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
                <table id="employee_table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Employee Email</th>
                    <th>Designation</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
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
 $(function () {
    var table = $('#employee_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('ajaxemployeelist') }}",
        columns: [
            {data: 'employee_id', name: 'employee_id'},
            {data: 'employee_name', name: 'employee_name'},
            {data: 'employee_email', name: 'employee_email'},
            {data: 'designation_name', name: 'designation_name'},
            {
                "targets": -1,
                "data": "employee_id",
                "className": "center",
                "render": function(data, type, row, meta) {
                    return '<button name="employee_id" id=' + data + ' value="Edit" class="btn btn-secondary update_record" style="margin:10%">Edit</button><button id=' + data + ' value="Delete" class="btn btn-danger delete_record" style="margin:10%">Delete</button>'
                }
            }
        ]
    });
    
  });

  toastr.options = {
    "closeButton": true,
    "newestOnTop": true,
    "positionClass": "toast-top-right"
  };

  $(document).on('click', '.delete_record', function() {
        $.ajax({
            type: "post",
            url: "{{ route('employee_delete') }}",
            data: {
                'employee_id': this.id,
                _token: '{{csrf_token()}}'
            },
            success: function(res) {
                if (res.status == 201) {
                    $('#employee_table').DataTable().ajax.reload();
                    toastr.success(res.message);
                } else {
                    toastr.error(res.message);
                }
            }
        });
    });

    $(document).on('click', '.update_record', function() {
        $.ajax({
            type: "post",
            url: "{{ route('employee_details') }}",
            data: {
                'employee_id': this.id,
                _token: '{{csrf_token()}}'
            },
            success: function(res) {
                $('#employee_id').val(res.employee_id);
                $('#employee_name').val(res.employee_name);
                $('#employee_email').val(res.employee_email);
                $('#designation_id').val(res.designation_id);
                $('#employeeupdatemodal').modal('show');
            }
        });
    });

    $(document).on('click', '.update_employee', function() {
        var formData = new FormData($('#updateform')[0]);
        formData.append("_token", '{{csrf_token()}}');
        $.ajax({
            type: "post",
            url: "{{ route('employee_update') }}",
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(res) {
                if (res.status == 201) {
                    toastr.success(res.message);
                    $('#employee_table').DataTable().ajax.reload();
                    $('#employeeupdatemodal').modal('hide');
                    document.getElementById("updateform").reset();
                } else {
                    toastr.error(res.message);
                }
            }
        });
    });

</script>
<div class="modal fade" id="employeeupdatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="employeeupdatemodal">Update Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="updateform" id="updateform" enctype="multipart/form-data">
      <h2>Employee Details</h2>
      <div class="form-group">
          <input type="hidden" name="employee_id" id="employee_id">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_employee">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>