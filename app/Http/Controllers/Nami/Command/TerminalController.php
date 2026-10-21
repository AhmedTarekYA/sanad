<?php

namespace App\Http\Controllers\Nami\Command;

use App\Services\Nami\CommandTerminalService as objService;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class TerminalController extends Controller
{

    public string $folderPath = "nami.terminal";

    public function index(objService $service) {
        $data["bladeTitle"] = __("auth.Server Terminal");
        $data["commands"] = $service->get();
        return view($this->folderPath . '.terminal', $data);
    }

    public function store(Request $request)
    {
        // dd($request->type);
        $command = $request->input('command');
        if (strpos($command, 'php artisan') !== false) {
            // Extract the Artisan command without 'php artisan'
            $artisanCommand = str_replace('php artisan ', '', $command);

            // Call the Artisan command
            Artisan::call($artisanCommand);
            $output = Artisan::output();

            return response()->json(['output' => $output]);
        } else {
            // Execute non-Artisan commands using Process
            $path = $request->type == "vendor" ? base_path() . '/vendor' : base_path();
            $process = Process::fromShellCommandline($command, $path);
            $process->setTimeout(3600); // Set timeout to 1 hour if needed
            $process->run();

            if (!$process->isSuccessful()) {
                return response()->json(['output' => 'Command failed: ' . $process->getErrorOutput()], 500);
            }

            $output = $process->getOutput();

            return response()->json(['output' => $output]);
        }
    }
}
