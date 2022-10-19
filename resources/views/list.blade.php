<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
  </head>
  <body>
      <div class="container" style="margin-top: 20px;">
        {{ csrf_field() }}
          <div class="row">
            <div class="col">
              <table class="table" id="table">
                <thead>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Precio</th>
                  <th>Cantidad</th>
                  <th></th>
                </thead>
                <tbody>
                  @foreach($products as $product)
                  <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->cant}}</td>
                    <td>
                      <button class="edit-modal btn btn-info"
                                  data-info="{{$product->id}},{{$product->name}},{{$product->description}},{{$product->price}},{{$product->cant}}"><span class="glyphicon glyphicon-edit"></span> Edit
                      </button>
                      <button class="delete-modal btn btn-danger"
                          data-info="{{$product->id}},{{$product->name}},{{$product->description}},{{$product->price}},{{$product->cant}}"><span class="glyphicon glyphicon-trash"></span> Delete
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

            </div>
          </div>

      </div>
  </body>
</html>

<div class="modal" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" readonly class="form-control" id="id">
        </div>
        <div class="form-group">  
          <input type="text" class="form-control" id="name">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="description">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="price">
        </div>        
        <div class="form-group">
          <input type="text" class="form-control" id="cant">
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span> Close
            </button>            
            <button type="button" class="btn actionBtn" data-dismiss="modal">
              <span id="footer_action_button" class='glyphicon'> </span>
            </button>
          </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.23/dist/sweetalert2.all.min.js" type="text/javascript"></script>

<script>
  $(document).ready(function() {
    $('#table').DataTable();
  
    function fillmodalData(details){
      $('#id').val(details[0]);
      $('#name').val(details[1]);
      $('#description').val(details[2]);
      $('#price').val(details[3]);
      $('#cant').val(details[4]);
    }
    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Edit');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff);
        $('#modalEdit').modal('show');
    });

   $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'update',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $("#id").val(),
                'name': $('#name').val(),
                'description': $('#description').val(),
                'price': $('#price').val(),
                'cant': $('#cant').val()
            },
            success: function(data) {
              window.location.reload();
            }
        });
    });

    $(document).on('click', '.delete-modal', function() {
            $('#footer_action_button').text(" Delete");
            $('#footer_action_button').removeClass('glyphicon-check');
            $('#footer_action_button').addClass('glyphicon-trash');
            $('.actionBtn').removeClass('btn-success');
            $('.actionBtn').addClass('btn-danger');
            $('.actionBtn').removeClass('edit');
            $('.actionBtn').addClass('delete');
            $('.modal-title').text('Delete');
            $('.deleteContent').show();
            $('.form-horizontal').hide();
            var stuff = $(this).data('info').split(',');
            eliminar(stuff[0]);
        });  

    function eliminar(id){
      Swal.fire({
          title: 'Estás seguro que deseas eliminar?',
          text: "No podrás revertir esta acción!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
          if (result.isConfirmed) {
            eliminarProducto(id);
          }
        })

    }
        

    function eliminarProducto(id){
        let url = "destroy";
        $.ajax({
            method: 'POST',
            type: 'json',
            url: url+'?id='+id,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                   window.location.reload();
            })
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
    }        

  });
 </script>