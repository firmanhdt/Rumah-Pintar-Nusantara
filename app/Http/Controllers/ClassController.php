<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function getSubjectsByClass($classId)
    {
        $class = ClassModel::with('subjects')->findOrFail($classId);
        return response()->json($class->subjects);
    }
}
