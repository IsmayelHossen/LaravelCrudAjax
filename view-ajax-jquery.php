@extends('layouts/app')
@section('content')
    <div class="container">

        <div class="col-md-12">
            <div class="clearfix">
                <span>Laravel - jQuery CRUD</span>
                <a class="btn btn-success btn-sm pull-right" onclick="create()">Add New</a>
            </div>

            <!--data listing table-->
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>NAME</td>
                    <td>EMAIL</td>
                    <td>PHONE</td>
                    <td>ACTION</td>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <!--data listing table-->

        </div>

    </div>
     <!-- modal -->
     <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title"></h4>
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control input-sm" type="text" name="name">
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input class="form-control input-sm" type="email" name="email">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input class="form-control input-sm" type="number" name="phone">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary btnSave"
                            onClick="store()">Save
                    </button>
                    <button type="button" class="btn btn-primary btnUpdate"
                            onClick="update()">Update
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script>
    var modalswitch=$('#modal');
    var datasave=$('.btnSave');
    var dataupdate=$('.btnUpdate');
    $.ajaxSetup({
     headers: {'X-CSRF-Token': '{{csrf_token()}}'}
});
 function collectrecords(){
     $.get('Ajaxcrud/data').then((data)=>{
         var html='';
         data.forEach(function(row){
             html +='<tr>'
             html +='<td>'+row.id+'</td>'
             html +='<td>'+row.name+'</td>'
             html +='<td>'+row.email+'</td>'
             html +='<td>'+row.phone+'</td>'
             html += '<td>'
             html += '<button type="button" class="btn btn-xs btn-warning btnEdit" title="Edit Record" >Edit</button>'
             html += '<button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' + row.id + '" title="Delete Record">Delete</button>'
             html += '</td> </tr>';
         })
         $('table tbody').html(html);
     })

 }
  collectrecords();
//   end get data system and modal start
function reset() {
    modalswitch.find('input').each(function () {
                $(this).val(null)
            })
        }
        //null model value for update,add
        function getInputs() {
            var id = $('input[name="id"]').val()
            var name = $('input[name="name"]').val()
            var email = $('input[name="email"]').val()
            var phone = $('input[name="phone"]').val()
            return {id: id, name: name, email: email, phone: phone}
        }
        //get model data value
        function create() {
            modalswitch.find('.modal-title').text('New Contact');
            reset();
            modalswitch.modal('show')
            datasave.show()
            dataupdate.hide()
        }
        //model end
        function store(){
            if(!confirm('Are you sure?')) return;
            $.ajax({
                method: 'POST',
                url:'/Ajaxcrud/store',
                data: getInputs(),
                dataType: 'JSON',
                success: function () {
                   // console.log('inserted')
                    reset()
                    modalswitch.modal('hide')
                    collectrecords();
                    swal({
                        title: "Good job!",
                        text: "Data Successfully Inserted",
                        icon: "success",
                        });
                }
            })
        }
        //edit machanism
        $('table').on('click', '.btnEdit', function () {
            modalswitch.find('.modal-title').text('Edit Contact')
            modalswitch.modal('show')
            datasave.hide()
            dataupdate.show()
            var id = $(this).parent().parent().find('td').eq(0).text()
            var name = $(this).parent().parent().find('td').eq(1).text()
            var email = $(this).parent().parent().find('td').eq(2).text()
            var phone = $(this).parent().parent().find('td').eq(3).text()
            $('input[name="id"]').val(id)
            $('input[name="name"]').val(name)
            $('input[name="email"]').val(email)
            $('input[name="phone"]').val(phone)
        })
        function update(){
            if(!confirm('Are you sure?')) return;
            $.ajax({
                method: 'POST',
                url:'/Ajaxcrud/update',
                data: getInputs(),
                dataType: 'JSON',
                success: function () {
                    
                    reset()
                    modalswitch.modal('hide')
                    collectrecords();
                    swal({
                        
                        text: "Data Successfully Updated",
                        icon: "success",
                        });
    
                }
            })
        }
        //update operation end
        $('table').on('click', '.btnDelete', function () {
            if(!confirm('Are you sure?')) return;
            //var id=$(this).attr('data-id');
             var id=$(this).data('id');
            var data={id:id};
            $.ajax({
                method: 'POST',
                url:'/Ajaxcrud/delete',
                data:data,
                dataType: 'JSON',
                success: function () {
                    //console.log('deleted');
                    collectrecords();
                    swal({
                        
                        text: "Data Successfully Deleted",
                        icon: "success",
                        });
    
                
                }
            })
        })
    </script>

    @endsection