<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
</head>
<body>
<form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">Upload</button>
</form>

</body>
</html>
