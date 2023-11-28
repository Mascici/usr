    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-light">
                <h3 class="card-title"><i class="fa fa-list text-blue"></i> Data User</h3>
                <div class="text-right">
                  
                <?php if($_SESSION['departemen']==1):?>
                  <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_user()" title="Add Data"><i class="fas fa-plus"></i> Add</button>
                  <?php endif ?>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabeluser" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th>NIK</th>
                      <th>Nama</th>
                      <th>TTL</th>
                      <th>Alamat</th>
                      <th>Pendidikan</th>
                      <th>Departemen</th>
                      <th>level</th>
                      <th>Grade</th>
                      <?php if($_SESSION['departemen']==1):?>
                      <th>Aksi</th>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($karyawan AS $kry): ?>
                      <tr>
                        <td><?=$kry->nik ?></td>
                        <td><?=$kry->nama ?></td>
                        <td><?=$kry->ttl ?></td>
                        <td><?=$kry->alamat ?></td>
                        <td><?=$kry->pendidikan ?></td>
                        <td><?=$kry->id_departemen ?></td>
                        <td><?=$kry->level ?></td>
                        <td><?=$kry->grade ?></td>
                        <?php if($_SESSION['departemen']==1):?>
                        <td>
                          <!-- <a class="btn btn-xs btn-outline-info" href="javascript:void(0)" title="View" onclick="vuser('<?=$kry->id ?>')"><i class="fas fa-eye"></i></a> -->
                          <a class="btn btn-xs btn-outline-primary" href="javascript:void(0)" title="Edit" onclick="edit_user(this)"data-id='<?=$kry->id?>'data-username='<?=$kry->username?>'data-password='<?=$kry->password?>'data-nik='<?=$kry->nik?>'data-nama='<?=$kry->nama?>'data-ttl='<?=$kry->ttl?>'data-alamat='<?=$kry->alamat?>'data-pendidikan='<?=$kry->pendidikan?>'data-departemen='<?=$kry->departemen?>'data-level='<?=$kry->level?>'data-grade='<?=$kry->grade?>'data-status='<?=$kry->status?>'><i class="fas fa-edit"></i></a>
                          <a class="btn btn-xs btn-outline-danger" href="javascript:void(0)" title="View" onclick="deluser('<?=$kry->id ?>')"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif ?>

                      </tr>
                      <?php endforeach ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>



    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title ">View User</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center" id="md_def">
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->  
    
    
    <script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {

 
 $("input").change(function(){
  $(this).parent().parent().removeClass('has-error');
  $(this).next().empty();
  $(this).removeClass('is-invalid');
});
 $("textarea").change(function(){
  $(this).parent().parent().removeClass('has-error');
  $(this).next().empty();
  $(this).removeClass('is-invalid');
});
 $("select").change(function(){
  $(this).parent().parent().removeClass('has-error');
  $(this).next().empty();
  $(this).removeClass('is-invalid');
});
});

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
  }

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

// Button Tabel

function riset(id){

  Swal.fire({
    title: 'Reset password?',
    text: "Pass Default: password123",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, reset it!'
  }).then((result) => {
   if (result.value) {
    $.ajax({
      url:"<?php echo site_url('user/reset');?>"+id,
      type:"POST",
      cache:false,
      dataType: 'json',
      success:function(respone){
        if (respone.status == true) {
          reload_table();
          Swal.fire(
            'Reset!',
            'Your password has been reset.',
            'success'
            );
        }else{
          Toast.fire({
            icon: 'error',
            title: 'Reset password Error!!.'
          });
        }
      }
    });
  }else if (result.dismiss === Swal.DismissReason.cancel) {
    Swal(
      'Cancelled',
      'Your imaginary file is safe :)',
      'error'
      )
  }
})
}
//view
function vuser(id){
      $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('.modal-title').text('View User');
    $("#modal-default").modal('show');
    $.ajax({
      url : '<?php echo base_url('user/viewuser'); ?>',
      type : 'post',
      data : 'table=tbl_user&id='+id,
      success : function(respon){
        $("#md_def").html(respon);
      }
    })
  }

//delete
function deluser(id){
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {

    $.ajax({
      url:"<?php echo site_url('Dashboard/hapusdata/');?>"+id,
      type:"POST",
      // data:"id="+id,
      cache:false,
      dataType: 'json',
      success:function(respone){
        if (respone.status) {
              location.href="<?=base_url('Dashboard')?>";
        }
      }
    });

  })
}



function add_user()
{
  save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add User'); // Set Title to Bootstrap modal title
  }

  function edit_user(el){
    var id=$(el).data('id');
    var username=$(el).data('username');
    var password=$(el).data('password');
    var nik=$(el).data('nik');
    var nama=$(el).data('nama');
    var ttl=$(el).data('ttl');
    var alamat=$(el).data('alamat');
    var pendidikan=$(el).data('pendidikan');
    var id_departemen=$(el).data('id_departemen');
    var level=$(el).data('level');
    var grade=$(el).data('grade');
    var status=$(el).data('status');
    // console.log(level);
    $('#id').val(id);
    $('#username').val(username);
    $('#password').val(password);
    $('#nik').val(nik);
    $('#nama').val(nama);
    $('#ttl').val(ttl);
    $('#alamat').val(alamat);
    $('#pendidikan').val(pendidikan);
    $('#id_departemen').val(id_departemen);
    $('#level').val(level);
    $('#grade').val(grade);
    $('#status').val(status);

   save_method = 'update';
    // $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url : "<?php echo site_url('user/edituser')?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {

        $('[name="id"]').val(data.id);
        $('[name="username"]').val(data.username);
        $('[name="password"]').val(data.password);
        $('[name="nik"]').val(data.nik);
        $('[name="nama"]').val(data.nama);
        $('[name="ttl"]').val(data.ttl);
        $('[name="alamat"]').val(data.alamat);
        $('[name="pendidikan"]').val(data.pendidikan);
        $('[name="id_departemen"]').val(data.id_departemen);
        $('[name="level"]').val(data.level);
        $('[name="grade"]').val(data.grade);
        $('[name="status"]').val(data.status);
        
        if (data.image==null) {
          var image = "<?php echo base_url('assets/foto/user/default.png')?>";
          $("#v_image").attr("src",image);
        }else{
         var image = "<?php echo base_url('assets/foto/user/')?>";
         $("#v_image").attr("src",image+data.image);
       }
       
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit User'); // Set title to Bootstrap modal title

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error get data from ajax');
          }
        });
  }

  function save()
  {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
    if(save_method == 'add') {
      url = "<?php echo site_url('Dashboard/insertdata')?>";
    } else {
      url = "<?php echo site_url('Dashboard/editdata')?>";
    }
    var formdata = new FormData($('#form')[0]);
    $.ajax({
      url : url,
      type: "POST",
      data: formdata,
      dataType: "JSON",
      cache: false,
      contentType: false,
      processData: false,
      success: function(data)
      {

            if(data.status) //if success close modal and reload ajax table
            {
              location.href="<?=base_url('Dashboard')?>";
              $('#modal_form').modal('hide');
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert(textStatus);
            // alert('Error adding / update data');
            Toast.fire({
              icon: 'error',
              title: 'Error!!.'
            });
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

          }
        });
  }

  var loadFile = function(event) {
    var image = document.getElementById('v_image');
    image.src = URL.createObjectURL(event.target.files[0]);
  };

  function batal() {
    $('#form')[0].reset();
    reload_table();
    var image = document.getElementById('v_image');
    image.src ="";
  }
</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h3 class="modal-title">User Form</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
          <!-- <?php echo form_open_multipart('', array('class' => 'form-horizontal', 'id' => 'form')) ?> -->
          <input type="hidden" value="" name="id" id="id"/> 
          <div class="card-body">
            <div class="form-group row ">
              <label for="username" class="col-sm-3 col-form-label">Username</label>
              <div class="col-sm-9 kosong">
                <input type="text" class="form-control" name="username" id="username" placeholder="username">
              </div>
            </div>
            <div class="form-group row ">
              <label for="password" class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-9 kosong">
                <input type="text" class="form-control" name="password" id="password" placeholder="password">
              </div>
            </div>
            <div class="form-group row ">
              <label for="nik" class="col-sm-3 col-form-label">NIK</label>
              <div class="col-sm-9 kosong">
                <input type="text" class="form-control" name="nik" id="nik" placeholder="NIK">
              </div>
            </div>
            <div class="form-group row ">
              <label for="nama" class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-9 kosong">
                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama">
              </div>
            </div>
            
            <div class="form-group row ">
              <label for="ttl" class="col-sm-3 col-form-label">ttl</label>
              <div class="col-sm-9 kosong">
                <input type="date" class="form-control " name="ttl" id="ttl" placeholder="ttl">
              </div>
            </div>
            <div class="form-group row ">
              <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
              <div class="col-sm-9 kosong">
                <input type="text" class="form-control " name="alamat" id="alamat" placeholder="alamat">
              </div>
            </div>
            <div class="form-group row ">
              <label for="pendidikan" class="col-sm-3 col-form-label">Pendidikan</label>
              <div class="col-sm-9 kosong">
                <input type="text" class="form-control " name="pendidikan" id="pendidikan" placeholder="pendidikan">
              </div>
            </div>

            <div class="form-group row ">
              <label for="id_departemen" class="col-sm-3 col-form-label">Departemen</label>
              <div class="col-sm-9 kosong">
              <select class="form-control" name="id_departemen" id="id_departemen">
                  <option value=""></option>
                  <option value="1">HR</option>
                  <option value="2">IT</option>
                  <option value="3">Purchasing</option>
                  <option value="4">Finance</option>
                  <option value="5">Logistic</option>
                </select>
              </div>
            </div>

            <div class="form-group row ">
              <label for="level" class="col-sm-3 col-form-label">level</label>
              <div class="col-sm-9 kosong">
              <select class="form-control" name="level" id="level">
                  <option value=""></option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
            </div>

            <div class="form-group row ">
              <label for="grade" class="col-sm-3 col-form-label">Grade</label>
              <div class="col-sm-9 kosong">
              <select class="form-control" name="grade" id="grade">
                  <option value=""></option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
            </div>

            <div class="form-group row ">
              <label for="status" class="col-sm-3 col-form-label">Status</label>
              <div class="col-sm-9 kosong">
                <select class="form-control" name="status" id="status">
                  <option value=""></option>
                  <option value="Y">Y</option>
                  <option value="N">N</option>
                </select>
              </div>
            </div>
          </div>
          <!-- <?php echo form_close(); ?> -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" onclick="batal()" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->