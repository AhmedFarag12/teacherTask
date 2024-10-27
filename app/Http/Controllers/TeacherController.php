<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // Display all teachers
    public function index()
    {
        $teachers = Teacher::all();
        return view('teachers.index', compact('teachers'));
    }

    // Store a new teacher
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $img = $request->file('image');
        $ext = $img->getClientOriginalExtension();
        $imagName = "teacher-" . uniqid() . ".$ext";
        $img->move(public_path('uploads/teachers'), $imagName);


        Teacher::create([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'image' => $imagName,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

       
        $teacher = Teacher::findOrfail($id);
        $imagName = $teacher->image;

        if ($request->hasFile('image')) {

            if ($imagName !== null) {
                unlink(public_path('uploads/teachers/') . $imagName);
            }
            $img = $request->file('img');
            $ext = $img->getClientOriginalExtension();
            $imagName = "teacher-" . uniqid() . ".$ext";
            $img->move(public_path('uploads/teachers/'), $imagName);
        }
        $teacher->update([
            'name' => $request->name,
            'specialization' => $request->specialization,
            "image" => $imagName
        ]);

        return redirect(route('teachers.index', $id));
    }

    // Delete a teacher
    public function destroy($id)
    {
        $teacher =  Teacher::findOrfail($id);

        if ($teacher->image !== null) {
            unlink(public_path('uploads/teachers/') . $teacher->image);
        }
        $teacher->delete();
        return redirect(route('teachers.index'));
    }
}
