<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::all()->sortDesc(); // Récupérer tous les fichiers téléversés depuis la base de données
        return view('index', ['files' => $files]); // Passer les fichiers à la vue index
    }

    public function store(Request $request)
    {
        // Validate the request data.
        $this->validate($request, [
            'file' => 'required_without:url|file|mimes:pdf',
            'url' => 'required_without:file|nullable|url',
            'name' => 'nullable|string',
        ]);

        set_time_limit(6000);
        ini_set('memory_limit', '4096M');

        if ($request->has('file')) {
            $file = $request->file('file');
            $name = $request->input('name') ?? $file->getClientOriginalName();
            $randomFileName = Str::random(40) . '.pdf';
            $path = $file->storeAs('files', $randomFileName); // Store the file
            $size = $file->getSize();
        } elseif ($request->has('url')) {
            $context = stream_context_create(['http' => ['header' => 'User-Agent: PHP']]);

            $file = file_get_contents($request->url, false, $context);
            $randomFileName = Str::random(40) . '.pdf';
            $name = $request->input('name') ?? basename(urldecode($request->url));
            $path = 'files/' . $randomFileName;

            file_put_contents(storage_path('app/' . $path), $file);
            $size = Storage::size($path);
        }

        if ($file) {
            // Create a new file model.
            $fileModel = new File();
            $fileModel->name = $name;
            $fileModel->path = $path;
            $fileModel->token = Str::random(60); // Generate a random token
            $fileModel->size = number_format(round($size / 1024 / 1024, 2), 2, ',', '.');
            $fileModel->save();

            $file = null;

            // return $fileModel;
            return redirect()->route('index');
        } else {
            echo 'Aucun fichier n\'a été soumis.';
            die();
        }
    }

    public function edit($token)
    {
        $fileModel = File::where('token', $token)->firstOrFail();

        if ($fileModel) {
            return view('edit', ['file' => $fileModel]);
        } else {
            echo 'Aucun fichier n\'a été soumis.';
            die();
        }
    }

    public function update(Request $request, $token)
    {
        $fileModel = File::where('token', $token)->firstOrFail();
        $oldFilePath = $fileModel->path;

        // Validate the request data.
        $this->validate($request, [
            'file' => 'nullable|file|mimes:pdf',
            'url' => 'nullable|url',
            'name' => 'required|string',
        ]);

        set_time_limit(6000);
        ini_set('memory_limit', '4096M');
        $file = '';
        if ($request->has('file')) {
            $file = $request->file('file');
            $name = $request->input('name') ?? $file->getClientOriginalName();
            $randomFileName = Str::random(40) . '.pdf';
            $path = $file->storeAs('files', $randomFileName); // Store the file
            $size = $file->getSize();
        } elseif ($request->has('url') && $request->url != '') {
            $context = stream_context_create(['http' => ['header' => 'User-Agent: PHP']]);

            $file = file_get_contents($request->url, false, $context);
            $randomFileName = Str::random(40) . '.pdf';
            $name = $request->input('name') ?? basename(urldecode($request->url));
            $path = 'files/' . $randomFileName;

            file_put_contents(storage_path('app/' . $path), $file);
            $size = Storage::size($path);
        }

        if ($file) {
            $fileModel->name = $name;
            $fileModel->path = $path;
            $fileModel->size = number_format(round($size / 1024 / 1024, 2), 2, ',', '.');
            $fileModel->save();
            $file = null;

            Storage::delete($oldFilePath);

            // return $fileModel;
            return redirect()->route('index');
        }
        if ($request->name) {
            $fileModel->name = $request->name;
            $fileModel->save();
            return redirect()->route('index');
        }

        echo 'Le formulaire est vide.';
        die();
    }

    public function download($token)
    {
        $file = File::where('token', $token)->firstOrFail();

        if ($file) {
            $filePath = storage_path('app/' . $file->path);
            $fileName = $file->name; // Utilisez le nom stocké dans la base de données
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            if (strtolower($fileExtension) !== 'pdf') {
                $fileName .= '.pdf';
            }

            return response()->download($filePath, $fileName);
        } else {
            //return response()->json(['error' => 'File not found or unauthorized access'], 404);
            echo "File not found !";
        }
    }
    public function delete($token)
    {
        $file = File::where('token', $token)->firstOrFail();

        if ($file) {

            $file->delete();
            Storage::delete($file->path);

            //return response()->json(['success' => 'File deleted successfully'], 200);
            return redirect()->route('index');
        } else {
            //return response()->json(['error' => 'File not found or unauthorized access'], 404);
            echo "File not found !";
        }
    }
}
