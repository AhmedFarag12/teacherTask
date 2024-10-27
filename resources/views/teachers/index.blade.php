<!-- resources/views/teachers/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    <title>Teachers</title>
</head>
<body>
    <h1 style="text-align: center;">Teachers</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2 style="text-align: center ; margin-top : 50px">Add New Teacher</h2>
    <form action="{{ route('teachers.store') }}" method="POST" style="align-items: center" enctype="multipart/form-data">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="specialization">Specialization:</label>
        <input type="text" name="specialization" required>
        <label for="image">Image:</label>
        <input type="file" name="image">
        <button  class="btn btn-success" type="submit">Add Teacher</button>
    </form>

    <h2 style="text-align: center">All Teachers</h2>
    <table border="3" cellpadding="10" cellspacing="0" style="text-align: center ; margin-top : 50px">
        <thead>
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Specialization</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->name }}</td>
                    <td>
                        @if ($teacher->image)
                        <img src="uploads/teachers/{{$teacher->image}}" alt="{{ $teacher->name }}" width="50" height="50">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ $teacher->specialization }}</td>
                    <td>
                        <!-- Edit Form -->
                        <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $teacher->name }}" required>
                            <input type="text" name="specialization" value="{{ $teacher->specialization }}" required>
                            <input type="file" name="image">
                            <button class="btn btn-primary"  type="submit">Update</button>
                        </form>

                        <!-- Delete Form -->
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <script src="/bootstrap-5.3.3-dist/js/bootstrap.js"></script>

</body>
</html>
