@extends('Backend.Layout.App')
@section('title', 'Gallery | Admin Panel')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Gallery</h4>
                <button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">Upload Image</button>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($images as $image)
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{ asset('Backend/uploads/photos/' . $image->image) }}" class="card-img-top" alt="Gallery Image">
                            <div class="card-body text-center">
                                <form action="{{ route('admin.settings.website.gallery.delete', $image->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload New Image</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.settings.website.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Select Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    // $(document).ready(function() {
    //     $('#uploadModal').on('hidden.bs.modal', function() {
    //         $(this).find('form').trigger('reset');
    //     });
    // });
</script>
@endsection