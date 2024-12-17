<?php

namespace App\Http\Controllers;

use App\Models\contents;
use App\Models\orders;
use App\Models\subcontent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    //
    public function newContent($order_id)
    {
        //dd($order_id);
        $contents = contents::where('order_id', $order_id)->where('content_status', 1)->orderBy('content_number')->get();
        $contador = count($contents);
        $order = orders::find($order_id);
        //dd($order);
        if ($contador == 0) {
            //dd($contents);
            return view('content.orderNewContent2', compact('order'));
        }
        else {
            //dd('sí tiene algo');
            //return view('content.orderContentOriginal', compact('order', 'contents'));
            return view('content.orderContentOriginal', compact('order', 'contents'));
        }
        
    }

    public function saveContent(Request $request, $order_id)
    {
        //dd($request, $order_id, $request->subpunto1_4);
        $pNumber = $request->points;
        for ($i=1; $i <= $pNumber; $i++) { 
            $j = 1;
            $content = new contents();
            $content->content_number = $i;
            $content->content_description = strtolower(request("content_description".$i));
            $content->order_id = $order_id;
            //dd($content);
            $content->save();
            //$sumx1 = request("dimx".$i);
            
            while (request("subpunto".$i.'_'.$j) != null) {
                $subcontent = new subcontent();
                $subcontent->subcontent_number = $j;
                $subcontent->subcontent_description = strtolower(request("subpunto".$i.'_'.$j));
                $subcontent->content_id = $content->content_id;
                $subcontent->save();
                $j++;
            }
            
        }
        return redirect()->route('content.index', $order_id)->with('success', 'Comisión agregada correctamente');
    }
    
    public function saveDocumentContent(Request $request)
    {
        //dd($request);
        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        $content = contents::find($request->id);
        
        $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('content', $fileName, 'public');
        $content->content_document = $fileName;
        $content->content_documentPath = '/storage/'.$filePath;
        
        $destinationPath = public_path('/storage/content');
        $document = $request->file('file');
        $document->move($destinationPath,$fileName);

        //dd($content);
        $content->save();
        $contents = contents::where('order_id', $content->order_id)->get();
        $order = orders::find($content->order_id);
        // dd($request, $content, $fileName, $filePath, $order);
        return view('content.orderContentOriginal', compact('order', 'contents'))->with('success', 'Documento cargado correctamente.');
        //return redirect()->route('content.index', $content->order_id)->with('success', 'Orden correctamente creada.');
        
    }

    public function saveDocumentSubcontent(Request $request)
    {
        //dd($request);
        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        $subcontent = subcontent::find($request->id);
        
        $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('subcontent', $fileName, 'public');

        $destinationPath = public_path('/storage/subcontent');
        $document = $request->file('file');
        $document->move($destinationPath,$fileName);
        
        //dd($request, $subcontent, $fileName, $filePath);
        $subcontent->subcontent_document = $fileName;
        $subcontent->subcontent_documentPath = '/storage/'.$filePath;
        //dd($order);1
        $subcontent->save();
        $contents = $contents = contents::where('order_id', $subcontent->RConSubcontent->order_id)->get();
        $order = orders::find($subcontent->RConSubcontent->order_id);
        return view('content.orderContentOriginal', compact('order', 'contents'))->with('success', 'Documento cargado correctamente.');
        //return redirect()->route('content.index', $content->order_id)->with('success', 'Orden correctamente creada.');
        
    }

    public function deleteDocumentContent($content_id)
    {
        //dd($content_id);
        $content = contents::find($content_id);
        $order_id = $content->order_id;
        // $fileToDelete = $content->content_documentPath;
        // if (Storage::exists($fileToDelete)) {
        //     Storage::delete($fileToDelete);
        // }
        $oldFile = $content->content_document;
        $oldFilePath = $content->content_documentPath; // Replace with the actual path to the file
        $newFilename = pathinfo($oldFilePath, PATHINFO_FILENAME) . '.pdf-DOWN';
        $newFilePath = '/storage/content/' . $newFilename;

        //dd($oldFilePath, $newFilename, $newFilePath);
        try {
            if ($oldFilePath) {
                // Storage::move($oldFilePath, '/storage/content/BAJA-'.$content->content_document);
                Storage::move($content->content_document, $newFilePath);
                $storage = $content->content_document;
                // $change = Storage::move('/storage/content/'.$storage, '/storage/content/'.$storage);
                $currentTime = Carbon::now()->subHour()->format('H_i_m');
                
                Storage::move('/public/content/'.$storage, '/public/content/DOWN-'.$currentTime.'-'.$storage);
                //Storage::move('/public/content/'.$storage, '/public/content/DOWN-'.$storage);
                //dd('/public/content/DOWN-'.$currentTime.'/'.$storage, Storage::move('/public/content/'.$storage, '/public/content/DOWN-'.$currentTime.'/'.$storage));
                // dd('/public/content/DOWN-'.$currentTime.'/'.$storage);
            }
            // Storage::delete($content->content_documentPath);
            
            $content->content_document = null;
            $content->content_documentPath = null;
            // dd(Storage::allDirectories(), Storage::allFiles('/public/content/'));
            // dd('/storage/content/DOWN-'.$storage, $change, public_path().'/storage/content/'.$storage , Storage::delete('/storage/content/'.$storage));
            $content->save();
    
            return redirect()->route('content.index', $order_id)->with('success', 'Documento eliminado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('content.index', $order_id)->with('error', 'Error en el documento.');
        }
        
    }

    public function deleteSubDocumentContent($subcontent_id)
    {
        //dd($subcontent_id);
        $subcontent = subcontent::find($subcontent_id);
        $order_id = $subcontent->RConSubcontent->order_id;
        $oldFilePath = $subcontent->subcontent_documentPath;
        try {
            if ($oldFilePath) {
                $currentTime = Carbon::now()->subHour()->format('H_i_m');
                $storage = $subcontent->subcontent_document;
                Storage::move('/public/subcontent/'.$storage, '/public/subcontent/DOWN-'.$currentTime.'-'.$storage);
                //dd(Storage::move('/public/subcontent/'.$storage, '/public/subcontent/DOWN-'.$currentTime.'-'.$storage));
            }
            // Storage::delete($content->content_documentPath);
            
            $subcontent->subcontent_document = null;
            $subcontent->subcontent_documentPath = null;
            // dd(Storage::allDirectories(), Storage::allFiles('/public/content/'));
            // dd('/storage/content/DOWN-'.$storage, $change, public_path().'/storage/content/'.$storage , Storage::delete('/storage/content/'.$storage));
            $subcontent->save();
    
            return redirect()->route('content.index', $order_id)->with('success', 'Documento del subcontenido eliminado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('content.index', $order_id)->with('error', 'Error en el documento.');
        }
    }

    public function ajaxUpCPriority(Request $request)
    {
        //return response()->json(('hola'), 200);
        $id = $request->content_id;
        //return response()->json(($id), 200);
        $contentO = contents::find($id);
        //return response()->json(($contentO), 200);
        $predecessor = $contentO->content_number - 1;
        $contentC = contents::where('order_id', $contentO->order_id)->where('content_number', $predecessor)->first();
        $originalNumber = $contentO->content_number;
        $contentO->content_number = $contentC->content_number;
        $contentC->content_number = $originalNumber;
        $contentO->save();
        $contentC->save();
        // return Response::json(array(
        //     'contentO' => $contentO,
        //     'contentC' => $contentC,
        // ));
        $contents = contents::all()->where('order_id', $contentO->order_id)->where('content_status', 1);
        return response()->json(($contents), 200);
        
        //return response()->json(('error'), 200);
        
    }

    public function ajaxDownCPriority(Request $request)
    {
        $id = $request->content_id;
        //return response()->json(($id), 200);
        $contentO = contents::find($id);
        //return response()->json(($contentO), 200);
        $sucessor = $contentO->content_number + 1;
        $contentC = contents::where('order_id', $contentO->order_id)->where('content_number', $sucessor)->first();
        $originalNumber = $contentO->content_number;
        $contentO->content_number = $contentC->content_number;
        $contentC->content_number = $originalNumber;
        $contentO->save();
        $contentC->save();
        // return Response::json(array(
        //     'contentO' => $contentO,
        //     'contentC' => $contentC,
        // ));
        $contents = contents::all()->where('order_id', $contentO->order_id)->where('content_status', 1);
        return response()->json(($contents), 200);
    }

    public function ajaxUpSCPriority(Request $request)
    {
        $id = $request->subcontent_id;
        $subcontentO = subcontent::find($id);
        $predecessor = $subcontentO->subcontent_number - 1;
        $subcontentC = subcontent::where('content_id', $subcontentO->content_id)->where('subcontent_number', $predecessor)->first();
        // return response()->json(($subcontentC), 200);
        $originalNumber = $subcontentO->subcontent_number;
        $subcontentO->subcontent_number = $subcontentC->subcontent_number;
        $subcontentC->subcontent_number = $originalNumber;
        $subcontentO->save();
        $subcontentC->save();
        $contents = contents::all()->where('order_id', $subcontentO->RConSubcontent->order_id)->where('content_status', 1);
        return response()->json(($contents), 200);
    }

    public function ajaxDownSCPriority(Request $request)
    {
        $id = $request->subcontent_id;
        $subcontentO = subcontent::find($id);
        $sucessor = $subcontentO->subcontent_number + 1;
        $subcontentC = subcontent::where('content_id', $subcontentO->content_id)->where('subcontent_number', $sucessor)->first();
        $originalNumber = $subcontentO->subcontent_number;
        $subcontentO->subcontent_number = $subcontentC->subcontent_number;
        $subcontentC->subcontent_number = $originalNumber;
        $subcontentO->save();
        $subcontentC->save();
        $contents = contents::all()->where('order_id', $subcontentO->RConSubcontent->order_id)->where('content_status', 1);
        return response()->json(($contents), 200);
    }

    public function addNewContent($id)
    {
        //dd($id);
        $contents = $contents = contents::where('order_id', $id)->orderBy('content_number')->get();
        return view('content.addContent', compact('id', 'contents'));
    }

    public function addNewSubcontent($id)
    {
        //dd($id);
        $content = contents::find($id);
        // $content = contents::where('content_id', $content->content_id)->first();
        $subcontents = subcontent::where('content_id', $content->content_id)->orderBy('subcontent_number')->get();
        return view('content.addSubcontent', compact('content', 'subcontents'));
    }

    public function saveNewContent(Request $request)
    {
        // dd($request);
        $flag = 0;
        // 1 es antes, 2 después
        if ($request->place == 1) {
            $pivotContent = contents::find($request->id);
            $contents = contents::select('content_id', 'content_number')->where('order_id', $pivotContent->order_id)->orderBy('content_number')->where('content_status', 1)->get();
            //dd($contents);
            
            foreach ($contents as $content) {
                if ($content->content_number == $pivotContent->content_number && $flag == 0) {
                    //dd($content->content_number + 1);
                    $flag = 1;
                    $newContent = new contents();
                    $newContent->content_number = $content->content_number;
                    $newContent->content_description = strtolower($request->description);
                    if ($request->file) {
                        $request->validate([
                            'file' => 'required|file|mimes:pdf'
                        ]);
                        $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
                        $filePath = $request->file('file')->storeAs('content', $fileName, 'public');
                        
                        $destinationPath = public_path('/storage/content');
                        $document = $request->file('file');
                        $document->move($destinationPath,$fileName);

                        $newContent->content_document = $fileName;
                        $newContent->content_documentPath = '/storage/'.$filePath;
                    }
                    $newContent->order_id = $pivotContent->order_id;
                    //dd($newContent);
                    $newContent->save();

                    for ($i=1; $i <= $request->points; $i++) { 
                        $subcontent = new subcontent();
                        $subcontent->subcontent_number = $i;
                        $subcontent->subcontent_description = strtolower(request("subcontent_description".$i));
                        $subcontent->content_id = $newContent->content_id;
                        if ($request->file('subFile'.$i)) {
                            $subFileName =  date("d-m-Y").'_'.$request->file('subFile'.$i)->getClientOriginalName();
                            $subFilePath = $request->file('subFile'.$i)->storeAs('subcontent', $subFileName , 'public');
                            $subcontent->subcontent_document = $subFileName;
                            $subcontent->subcontent_documentPath = '/storage/'.$subFilePath;
                        }
                        
                        $subcontent->save();
                    }
                    $contenido = contents::find($content->content_id);
                    $contenido->content_number = $content->content_number + 1;
                    //$content->content_number = $content->content_number + 1;
                    //dd($contenido);
                    $contenido->save();
                }
                elseif ($flag == 1) {
                    //$content->content_number = $content->content_number + 1;
                    $contenido = contents::find($content->content_id);
                    $contenido->content_number = $content->content_number + 1;
                    $contenido->save();
                }
            }
        } elseif($request->place == 2) {
            $pivotContent = contents::find($request->id);
            $contents = contents::select('content_id', 'content_number')->where('order_id', $pivotContent->order_id)->where('content_status', 1)->orderBy('content_number')->get();
            //dd($contents);
            
            foreach ($contents as $content) {
                if ($content->content_number > $pivotContent->content_number && $flag == 0) {
                    //dd($content->content_number + 1);
                    $flag = 1;
                    $newContent = new contents();
                    $newContent->content_number = $content->content_number;
                    $newContent->content_description = strtolower($request->description);
                    if ($request->file) {
                        $request->validate([
                            'file' => 'required|file|mimes:pdf'
                        ]);
                        $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
                        $filePath = $request->file('file')->storeAs('content', $fileName, 'public');

                        $destinationPath = public_path('/storage/content');
                        $document = $request->file('file');
                        $document->move($destinationPath,$fileName);
                        
                        $newContent->content_document = $fileName;
                        $newContent->content_documentPath = '/storage/'.$filePath;
                    }
                    $newContent->order_id = $pivotContent->order_id;
                    //dd($newContent);
                    $newContent->save();

                    for ($i=1; $i <= $request->points; $i++) { 
                        $subcontent = new subcontent();
                        $subcontent->subcontent_number = $i;
                        $subcontent->subcontent_description = strtolower(request("subcontent_description".$i));
                        $subcontent->content_id = $newContent->content_id;
                        if ($request->file('subFile'.$i)) {
                            $subFileName =  date("d-m-Y").'_'.$request->file('subFile'.$i)->getClientOriginalName();
                            $subFilePath = $request->file('subFile'.$i)->storeAs('subContent', $subFileName , 'public');
                            $subcontent->subcontent_document = $subFileName;
                            $subcontent->subcontent_documentPath = '/storage/'.$subFilePath;
                        }
                        
                        $subcontent->save();
                    }
                    $contenido = contents::find($content->content_id);
                    $contenido->content_number = $content->content_number + 1;
                    // $content->content_number = $content->content_number + 1;
                    // dd($contenido);
                    $contenido->save();
                }
                elseif ($flag == 1) {
                    //$content->content_number = $content->content_number + 1;
                    $contenido = contents::find($content->content_id);
                    $contenido->content_number = $content->content_number + 1;
                    $contenido->save();
                }
            }
            if ($flag == 0) {
                $pivotNumber = $pivotContent->content_number;
                $newContent = new contents();
                $newContent->content_number = $pivotNumber + 1;
                $newContent->content_description = strtolower($request->description);
                if ($request->file) {
                    $request->validate([
                        'file' => 'required|file|mimes:pdf'
                    ]);
                    $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
                    $filePath = $request->file('file')->storeAs('content', $fileName, 'public');
                    
                    $destinationPath = public_path('/storage/content');
                    $document = $request->file('file');
                    $document->move($destinationPath,$fileName);

                    $newContent->content_document = $fileName;
                    $newContent->content_documentPath = '/storage/'.$filePath;     
                }
                $newContent->order_id = $pivotContent->content_id;
                dd($newContent, $pivotContent->content_id);
                $newContent->save();

                for ($i=1; $i <= $request->points; $i++) { 
                    $pivotNumber ++;
                    $subcontent = new subcontent();
                    $subcontent->subcontent_number = $subcontent->subcontent_number + $i;
                    $subcontent->subcontent_description = strtolower(request("subcontent_description".$i));
                    $subcontent->content_id = $subcontent->content_id;
                    if ($request->file('subFile'.$i)) {
                        $subFileName =  date("d-m-Y").'_'.$request->file('subFile'.$i)->getClientOriginalName();
                        $subFilePath = $request->file('subFile'.$i)->storeAs('subcontent', $subFileName , 'public');
                        $subcontent->subcontent_document = $subFileName;
                        $subcontent->subcontent_documentPath = '/storage/'.$subFilePath;
                    }
                    //dd($subContents, $newSubcontent, $subcontent);
                    $subcontent->save();
                }
            }
        }
        //dd($contents);
        return redirect()->route('content.index', $pivotContent->order_id)->with('success', 'Comisión agregada correctamente');
    }

    public function saveNewSubcontent(Request $request)
    {
        // dd($request);
        $flag = 0;
        // 1 es antes, 2 después
        if ($request->place == 1) {
            $pivotSubcontent = subcontent::find($request->id);
            $subContents = subcontent::select('content_id', 'subcontent_id', 'subcontent_number')->where('content_id', $pivotSubcontent->content_id)
                    ->orderBy('subcontent_number')->where('subcontent_status', 1)->get();
            //dd($contents);
            $pivotNumber = $pivotSubcontent->subcontent_number;
            foreach ($subContents as $subContent) {
                $pivotNumber ++;
                if ($subContent->subcontent_number == $pivotSubcontent->subcontent_number && $flag == 0) {
                    //dd($content->content_number + 1);
                    $flag = 1;
                    $newSubcontent = new subcontent();
                    $newSubcontent->subcontent_number = $subContent->subcontent_number;
                    $newSubcontent->subcontent_description = $request->description;
                    if ($request->file) {
                        $request->validate([
                            'file' => 'required|file|mimes:pdf'
                        ]);
                        $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
                        $filePath = $request->file('file')->storeAs('subcontent', $fileName, 'public');
                        
                        $destinationPath = public_path('/storage/subcontent');
                        $document = $request->file('file');
                        $document->move($destinationPath,$fileName);

                        $newSubcontent->subcontent_document = $fileName;
                        $newSubcontent->subcontent_documentPath = '/storage/'.$filePath;     
                    }
                    $newSubcontent->content_id = $pivotSubcontent->content_id;
                    //dd($newContent);
                    $newSubcontent->save();

                    for ($i=1; $i <= $request->points; $i++) { 
                        $pivotNumber ++;
                        $subcontent = new subcontent();
                        $subcontent->subcontent_number = $newSubcontent->subcontent_number + $i;
                        $subcontent->subcontent_description = request("subcontent_description".$i);
                        $subcontent->content_id = $newSubcontent->content_id;
                        if ($request->file('subFile'.$i)) {
                            $subFileName =  date("d-m-Y").'_'.$request->file('subFile'.$i)->getClientOriginalName();
                            $subFilePath = $request->file('subFile'.$i)->storeAs('subcontent', $subFileName , 'public');
                            $subcontent->subcontent_document = $subFileName;
                            $subcontent->subcontent_documentPath = '/storage/'.$subFilePath;
                        }
                        
                        $subcontent->save();
                    }
                    $subContenido = subcontent::find($subContent->subcontent_id);
                    $subContenido->subcontent_number = $pivotNumber;
                    //$content->content_number = $content->content_number + 1;
                    //dd($contenido);
                    $subContenido->save();
                }
                if ($flag == 1) {
                    //$content->content_number = $content->content_number + 1;
                    $subContenido = subcontent::find($subContent->subcontent_id);
                    $subContenido->subcontent_number = $pivotNumber;
                    $subContenido->save();
                }
            }
        } elseif($request->place == 2) {
            $pivotSubcontent = subcontent::find($request->id);
            $pivotNumber = $pivotSubcontent->subcontent_number;
            $subContents = subcontent::select('content_id', 'subcontent_id', 'subcontent_number')
                    ->where('content_id', $pivotSubcontent->content_id)
                    ->where('subcontent_status', 1)
                    ->orderBy('subcontent_number')
                    ->get();
            // $addedNumber = $request->points + 2;
            // dd($pivotSubcontent, $subContents, $pivotNumber);
            foreach ($subContents as $subContent) {
                $pivotNumber ++;
                // dd($subContent->subcontent_number, $pivotSubcontent->subcontent_number, $pivotNumber);
                if ($subContent->subcontent_number > $pivotSubcontent->subcontent_number && $flag == 0) {
                    // dd($subContent->subcontent_number + 1);
                    $flag = 1;
                    $newSubcontent = new subcontent();
                    $newSubcontent->subcontent_number = $subContent->subcontent_number;
                    $newSubcontent->subcontent_description = strtolower($request->description);
                    if ($request->file) {
                        $request->validate([
                            'file' => 'required|file|mimes:pdf'
                        ]);
                        $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
                        $filePath = $request->file('file')->storeAs('subcontent', $fileName, 'public');
                        
                        $destinationPath = public_path('/storage/subcontent');
                        $document = $request->file('file');
                        $document->move($destinationPath,$fileName);

                        $newSubcontent->subcontent_document = $fileName;
                        $newSubcontent->subcontent_documentPath = '/storage/'.$filePath;                        
                    }
                    $newSubcontent->content_id = $pivotSubcontent->content_id;
                    // dd($newSubcontent);
                    $newSubcontent->save();

                    for ($i=1; $i <= $request->points; $i++) { 
                        $pivotNumber ++;
                        $subcontent = new subcontent();
                        $subcontent->subcontent_number = $newSubcontent->subcontent_number + $i;
                        $subcontent->subcontent_description = strtolower(request("subcontent_description".$i));
                        $subcontent->content_id = $newSubcontent->content_id;
                        if ($request->file('subFile'.$i)) {
                            $subFileName =  date("d-m-Y").'_'.$request->file('subFile'.$i)->getClientOriginalName();
                            $subFilePath = $request->file('subFile'.$i)->storeAs('subcontent', $subFileName , 'public');
                            $subcontent->subcontent_document = $subFileName;
                            $subcontent->subcontent_documentPath = '/storage/'.$subFilePath;
                        }
                        //dd($subContents, $newSubcontent, $subcontent);
                        $subcontent->save();
                    }
                    $subContenido = subcontent::find($subContent->subcontent_id);
                    //dd($subContenido);
                    $subContenido->subcontent_number = $subContent->subcontent_number + 1;
                    $subContenido->save();
                } elseif ($flag == 1) {
                    $subContenido = subcontent::find($subContent->subcontent_id);
                    // $subContenido->subcontent_number = $subContent->subcontent_number + $addedNumber;
                    $subContenido->subcontent_number = $pivotNumber;
                    //dd($subContenido);
                    $subContenido->save();
                }

                

            }
            if ($flag == 0) {
                $pivotNumber = $pivotSubcontent->subcontent_number;
                $newSubcontent = new subcontent();
                $newSubcontent->subcontent_number = $pivotNumber + 1;
                $newSubcontent->subcontent_description = strtolower($request->description);
                if ($request->file) {
                    $request->validate([
                        'file' => 'required|file|mimes:pdf'
                    ]);
                    $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
                    $filePath = $request->file('file')->storeAs('subcontent', $fileName, 'public');
                    
                    $destinationPath = public_path('/storage/subcontent');
                    $document = $request->file('file');
                    $document->move($destinationPath,$fileName);

                    $newSubcontent->subcontent_document = $fileName;
                    $newSubcontent->subcontent_documentPath = '/storage/'.$filePath;     
                }
                $newSubcontent->content_id = $pivotSubcontent->content_id;
                // dd($newSubcontent);
                $newSubcontent->save();

                for ($i=1; $i <= $request->points; $i++) { 
                    $pivotNumber ++;
                    $subcontent = new subcontent();
                    $subcontent->subcontent_number = $newSubcontent->subcontent_number + $i;
                    $subcontent->subcontent_description = strtolower(request("subcontent_description".$i));
                    $subcontent->content_id = $newSubcontent->content_id;
                    if ($request->file('subFile'.$i)) {
                        $subFileName =  date("d-m-Y").'_'.$request->file('subFile'.$i)->getClientOriginalName();
                        $subFilePath = $request->file('subFile'.$i)->storeAs('subcontent', $subFileName , 'public');
                        $subcontent->subcontent_document = $subFileName;
                        $subcontent->subcontent_documentPath = '/storage/'.$subFilePath;
                    }
                    //dd($subContents, $newSubcontent, $subcontent);
                    $subcontent->save();
                }
            }
        } elseif($request->place == 'first') {
            $newSubcontent = new subcontent();
            $newSubcontent->subcontent_number = 1;
            $newSubcontent->subcontent_description = $request->description;
            if ($request->file) {
                $request->validate([
                    'file' => 'required|file|mimes:pdf'
                ]);
                $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('subcontent', $fileName, 'public');
                
                $destinationPath = public_path('/storage/subcontent');
                $document = $request->file('file');
                $document->move($destinationPath,$fileName);

                $newSubcontent->subcontent_document = $fileName;
                $newSubcontent->subcontent_documentPath = '/storage/'.$filePath;    
            }
            $newSubcontent->content_id = $request->content;
            // dd($newSubcontent);
            $newSubcontent->save();

            for ($i=1; $i <= $request->points; $i++) { 
                $subcontent = new subcontent();
                $subcontent->subcontent_number = $newSubcontent->subcontent_number + $i;
                $subcontent->subcontent_description = request("subcontent_description".$i);
                $subcontent->content_id = $newSubcontent->content_id;
                if ($request->file('subFile'.$i)) {
                    $subFileName =  date("d-m-Y").'_'.$request->file('subFile'.$i)->getClientOriginalName();
                    $subFilePath = $request->file('subFile'.$i)->storeAs('subcontent', $subFileName , 'public');
                    $subcontent->subcontent_document = $subFileName;
                    $subcontent->subcontent_documentPath = '/storage/'.$subFilePath;
                }
                
                $subcontent->save();
            }
            return redirect()->route('content.index', $newSubcontent->RConSubcontent->order_id)->with('success', 'Subcontenido agregado correctamente');
        }
        //dd($contents);
        return redirect()->route('content.index', $pivotSubcontent->RConSubcontent->order_id)->with('success', 'Subcontenido agregado correctamente');
    }

    public function GPViewContent($id) {
        $order = orders::find($id);
        if ($order->order_status != 3) {
            return redirect()->route('orders.GPOrdersView')->with('error', 'Órden no encontrada.');
        } else {
            $contents = contents::where('order_id', $id)->where('content_status', 1)->orderBy('content_number')->get();
            //dd($order);
            //return view('content.orderContentOriginal', compact('order', 'contents'));
            return view('content.GPorderContent', compact('order', 'contents'));
        }
    }

    public function internalReviewContent($id) {
        $contents = contents::where('order_id', $id)->where('content_status', 1)->orderBy('content_number')->get();
        $contador = count($contents);
        $order = orders::find($id);
        //dd($order);
        return view('content.orderContentOriginal', compact('order', 'contents'));
        
    }

    public function updateContent(Request $request) {
        //dd($request);
        $content = contents::find($request->id);
        $content->content_description = $request->description;
        $content->save();

        return redirect()->route('content.index', $content->order_id)->with('success', 'Contenido modificado correctamente');
    }

    public function updateSubcontent(Request $request) {
        //dd($request);
        $subcontent = subcontent::find($request->id);
        $subcontent->subcontent_description = $request->description;
        $subcontent->save();

        return redirect()->route('content.index', $subcontent->RConSubcontent->order_id)->with('success', 'Contenido modificado correctamente');
    }

    public function disableContent($id) {
        // dd($id);
        $originalContent = contents::find($id);
        $originalContent->content_status = 2;
        $originalContent->save();
        $contents = contents::all()->where('order_id', $originalContent->order_id);
        $flag = 0;
        foreach ($contents as $content) {
            if ($content->content_number == ($originalContent->content_number + 1) && $flag == 0) {
                $flag = 1;
            } elseif ($flag = 1) {
                $content->content_number = $content->content_number - 1;
                $content->save();
            } 
        }
        // dd($contents);

        return redirect()->route('content.index', $originalContent->order_id)->with('success', 'Punto dado de baja correctamente');
    }

    public function disableSubcontent($id) {
        // dd($id);
        $originalSubcontent = subcontent::find($id);
        $originalSubcontent->subcontent_status = 2;
        $originalSubcontent->save();
        
        $subcontents = subcontent::all()->where('content_id', $originalSubcontent->content_id);
        $flag = 0;
        foreach ($subcontents as $subcontent) {
            if ($subcontent->subcontent_number == ($originalSubcontent->subcontent_number + 1) && $flag == 0) {
                $flag = 1;
            } elseif ($flag == 1) {
                $subcontent->subcontent_number = $subcontent->subcontent_number -1;
                $subcontent->save();
            } 
            
        }
        // dd($originalSubcontent, $subcontents);
        return redirect()->route('content.index', $originalSubcontent->RConSubcontent->order_id)->with('success', 'Subpunto dado de baja correctamente');
    }
}
