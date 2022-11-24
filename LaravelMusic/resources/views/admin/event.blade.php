@extends('layouts.admin')

@section('title')
Sự kiện
@endsection

@section('content')
{{-- <event>
</event> --}}
<div class="card shadow">
<div class="card-body">
<span class="h3">
Tất cả sự kiện
</span>
<span class="float-right">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eventmodal">
<i class="fa fa-plus"></i>
</button>
</span>
<br><br>
@if(count($events) > 0)
<div class="table-responsive">
<table class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Tiêu đề</th>
            <th scope="col">Vị trí</th>
            <th scope="col">Ngày</th>
            <th scope="col">Hành động</th>
          </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
          <tr>
            <th scope="row">{{$event->id}}</th>
            <td>{{$event->title}}</td>
            <td>{{$event->location}}</td>
          <td>{{$event->date}} {{$event->time}}</td>
            <td>
                <button onclick="editevent({{$event}})" class="btn btn-primary btn-sm">
                    Sửa</button>
                <button onclick="deleteevent({{$event->id}})" class="btn btn-danger btn-sm">
Xóa</i>
    </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
      @else
<p class="h3">Chưa có sự kiện nào được thêm!</p>
      @endif
</div>
</div>

<!--Edit event modal-->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="modaltitle">Sửa sự kiện</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <div id="msgs" class="msgs">

    </div>
    <form id="editform">
    @csrf
    <div class="form-group">
    <label for="title">Tiêu đề sự kiện
    </label>
    <input type="text" name="title" class="form-control" id="edittitle" required>
    </div>
    <div class="form-group">
    <label for="location">Địa điểm</label>
    <input type="text" name="location" class="form-control" id="editlocation" required>
    </div>

    <div class="form-group">
    <label for="title">Mô tả sự kiện</label>
    <textarea name="content" id="editcontent" class="form-control" rows="5" required></textarea>
    </div>

    <div class="form-group">
    <div class="row">
    <div class="col-8">
    <label for="title">Ngày sự kiện</label>
    <input type="date" name="date" class="form-control" id="editdate" required>

    </div>
    <div class="col-4">
    <label for="title">Giờ</label>
    <input type="time" name="time" class="form-control" id="edittime" required>

    </div>
    </div>
    </div>

    <div class="form-group">

    <label for="image">Ảnh sự kiện</label>
    <input type="file" name="image" id="editimage">
    <img src="#" alt="preview" id="previewedit" style="width: 20%;">
    </div>

    </div>
    <div class="modal-footer">
    <input type="hidden" name="id" id="editid" hidden="editid">
        <button type="button" class="btn btn-secondary" id="submit" data-dismiss="modal">Đóng</button>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </div>
    </form>
    </div>
    </div>
    </div>




<!--Event modal-->
<div class="modal fade" id="eventmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLongTitle">Thêm sự kiện</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<div id="msgs" class="msgs">

</div>
<form id="eventform">
@csrf
<div class="form-group">
<label for="title">Tiêu đề</label>
<input type="text" name="title" class="form-control" id="title" required>
</div>
<div class="form-group">
<label for="location">Vị trí</label>
<input type="text" name="location" class="form-control" id="location" required>
</div>

<div class="form-group">
<label for="title">Miêu tả sự kiện</label>
<textarea name="content" id="content" class="form-control" rows="5" required></textarea>
</div>

<div class="form-group">
<div class="row">
<div class="col-8">
<label for="title">Ngày </label>
<input type="date" name="date" class="form-control" id="date" required>

</div>
<div class="col-4">
<label for="title">Giờ</label>
<input type="time" name="time" class="form-control" id="time" required>

</div>
</div>
</div>

<div class="form-group">

<label for="image">Ảnh sự kiện</label>
<input type="file" name="image" id="image" required>
<img src="#" alt="preview" id="previewimg" style="width: 20%;">
</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" id="submit" data-dismiss="modal">Xóa</button>
<button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</div>
</form>
</div>
</div>
</div>
<!--end event modal-->


@push('script')
<script>

<!--Edit Modal-->
function editevent(event){
    $('#modaltitle').text("Edit " +event.title)
    $('#edittitle').val(event.title)
    $('#editlocation').val(event.location)
    $('#editcontent').val(event.description)
    $('#editdate').val(event.date)
    $('#edittime').val(event.time)
    $('#editid').val(event.id)

    //Passing the image from db to preview
    $("#previewedit").attr('src', "/images/event/" +event.image)
    $('#editmodal').modal('show')

//update event
$('#editform').submit(function(e){
    e.preventDefault();
    $("#loading").show()
    $("#msgs").html("");
        var form = $("#editform")[0];
		var _data = new FormData(form);
		$.ajax({
			url: '{{url(route("editevent"))}}',
			data: _data,
			enctype: 'multipart/form-data',
			processData: false,
			contentType:false,
			type: 'POST',
			success: function(data){
                $("#loading").hide()
                toastr.success("Đã thêm sự kiện");
                $('#editform').trigger('reset');
                $('#editmodal').modal('hide')
                setTimeout(()=>{
                    location.reload();
                }, 1000)
            },
			error: function(result){
                $("#loading").hide()
let errors = result.responseJSON.errors;
console.log(errors);
$.each(errors, function(key, value){
let msgs = "<div class='alert alert-danger'>" +value +"</div>";
$('#msgs').append(msgs);
})
   toastr.error('Không thể thêm sự kiện', 'Đã xảy ra lỗi!');
			}
		});
    });

}



function readURL(input, image) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function(e) {
image.attr('src', e.target.result);
}
reader.readAsDataURL(input.files[0]);
}
}
<!-- create event-->
$("#image").change(function() {
   let image = $("#previewimg");
    readURL(this, image);
});


$("#editimage").change(function() {
    let image = $("#previewedit");
    readURL(this, image);
});

$('#eventform').submit(function(e){
    e.preventDefault();
    $("#loading").show()
    $("#msgs").html("");
        var form = $("#eventform")[0];
		var _data = new FormData(form);
		$.ajax({
			url: '{{url(route("addevent"))}}',
			data: _data,
			enctype: 'multipart/form-data',
			processData: false,
			contentType:false,
			type: 'POST',
			success: function(data){
                $("#loading").hide()
                toastr.success("Sự kiện mới đã được thêm");
                $('#eventform').trigger('reset');
                $('#eventmodal').modal('hide')
                setTimeout(()=>{
                    location.reload();
                }, 1000)
            },
			error: function(result){
                $("#loading").hide()
let errors = result.responseJSON.errors;
console.log(errors);
$.each(errors, function(key, value){
let msgs = "<div class='alert alert-danger'>" +value +"</div>";
$('#msgs').append(msgs);
})
   toastr.error('Không thể thêm sự kiện', 'Đã xảy ra lỗi!');
			}
		});
    });

//delete event
function deleteevent(id){
if(confirm("Are you sure you want to delete")){
axios.post('{{route('deleteevent')}}', {
    id: id
}).then((response)=>{
toastr.success('Đã xóa sự kiện!')
location.reload();
}).catch((error)=>{
    toastr.error('Lỗi kết nối mạng!')
})
}
}

</script>

@endpush

@endsection
