<?php

namespace App\Http\Controllers\Infraction;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Infraction;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class InfractionController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $infractions = Infraction::all();
        if ($infractions->isEmpty()) {
            return response()->json([
                'message' => 'No infractions found',
            ], 404);
        }
        return response()->json([
            'infractions' => $infractions,
        ], 200);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $infraction = Infraction::find($id);
        if (!$infraction) {
            return response()->json([
                'message' => 'Infraction not found',
            ], 404);
        }
        return response()->json([
            'infraction' => $infraction,
        ], 200);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'plate' => 'required|string|max:6',
                'type' => 'required|string|max:255',
                'velocity' => 'required|numeric',
                'height' => 'numeric',
                'longitude' => 'required|numeric',
                'latitude' => 'required|numeric',
            ]);

            $vehicle = Vehicle::where('plate', $request->plate)->first();
            if (!$vehicle) {
                $vehicle = Vehicle::create([
                    'plate' => $request->plate,
                    'type' => $request->type,
                ]);
            }

            $cities = City::all();
            $nearby = null;
            foreach ($cities as $city) {
                $delta = sqrt(pow($city->longitude - $request->longitude, 2) + pow($city->latitude - $request->latitude, 2));
                $nearby[] = [
                    'city_id' => $city->id,
                    'delta' => $delta,
                ];
            }

            for ($i = 0; $i < count($nearby); $i++) {
                for ($j = $i + 1; $j < count($nearby); $j++) {
                    if ($nearby[$i]['delta'] > $nearby[$j]['delta']) {
                        $aux = $nearby[$i];
                        $nearby[$i] = $nearby[$j];
                        $nearby[$j] = $aux;
                    }
                }
            }
            $city = City::find($nearby[0]['city_id']);
            if ($vehicle->type == 'flight') {
                if ($request->height > 50 || $request->velocity > 120) {
                    $infraction = Infraction::create([
                        'description' => 'La multa es válidad',
                        'longitude' => $request->longitude,
                        'latitude' => $request->latitude,
                        'height' => $request->height,
                        'velocity' => $request->velocity,
                        // 'image_id' => null,
                        'vehicle_id' => $vehicle->id,
                        'city_id' => $city->id,
                    ]);
                } else {
                    $infraction = Infraction::create([
                        'description' => 'La multa es inválida',
                        'longitude' => $request->longitude,
                        'latitude' => $request->latitude,
                        'height' => $request->height,
                        'velocity' => $request->velocity,
                        // 'image_id' => null,
                        'vehicle_id' => $vehicle->id,
                        'city_id' => $city->id,
                    ]);
                }
            } else {
                if ($request->velocity > 120) {
                    $infraction = Infraction::create([
                        'description' => 'La multa es válidad',
                        'longitude' => $request->longitude,
                        'latitude' => $request->latitude,
                        'height' => $request->height,
                        'velocity' => $request->velocity,
                        // 'image_id' => null,
                        'vehicle_id' => $vehicle->id,
                        'city_id' => $city->id,
                    ]);
                } else {
                    $infraction = Infraction::create([
                        'description' => 'La multa es inválida',
                        'longitude' => $request->longitude,
                        'latitude' => $request->latitude,
                        'height' => $request->height,
                        'velocity' => $request->velocity,
                        // 'image_id' => null,
                        'vehicle_id' => $vehicle->id,
                        'city_id' => $city->id,
                    ]);
                }
            }

        } catch (\Exception $e) {
            return response()->json([
                // message' => 'Infraction not created',
                'message' => $e->getMessage(),
            ], 404);
        }
        return response()->json([
            'distance' => $nearby[0]['delta'] . 'mts',
            'infraction_status' => $infraction->description,
            'city' => $city->name,
        ], 200);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $infraction = Infraction::find($id);
        if (!$infraction) {
            return response()->json([
                'message' => 'Infraction not found',
            ], 404);
        }
        $infraction->delete();
        return response()->json([
            'message' => 'Infraction deleted',
        ], 200);
    }

    public function indexValid(): \Illuminate\Http\JsonResponse
    {
        $infractions = Infraction::with(['city', 'vehicle'])->where('description', 'La multa es válidad')->get();
        if ($infractions->isEmpty()) {
            return response()->json([
                'message' => 'No infractions found',
            ], 404);
        }
        return response()->json([
            'multas_validas' => $infractions,
        ], 200);
    }

    public function indexInvalid(): \Illuminate\Http\JsonResponse
    {
        $infractions = Infraction::with(['city', 'vehicle'])->where('description', 'La multa es inválida')->get();
        if ($infractions->isEmpty()) {
            return response()->json([
                'message' => 'No infractions found',
            ], 404);
        }
        return response()->json([
            'multas_invalidas' => $infractions,
        ], 200);
    }
}
