<?php

use App\Http\Controllers\API\Analysis\AnalysisController;
use App\Http\Controllers\API\Circuits\CircuitController;
use App\Http\Controllers\API\Drivers\DriverController;
use App\Http\Controllers\API\Drivers\DriverListController;
use App\Http\Controllers\API\GrandPrix\GrandPrixController;
use App\Http\Controllers\API\LapTimes\LapTimesController;
use App\Http\Controllers\API\RaceReport\RaceReportController;
use App\Http\Controllers\API\Seasons\SeasonController;
use App\Http\Controllers\API\Standings\StandingsController;
use App\Http\Controllers\API\Constructors\ConstructorListController;
use App\Http\Controllers\API\Constructors\ConstructorController;
use App\Http\Controllers\API\Circuits\CircuitListController;
use App\Http\Controllers\API\GrandPrix\NextGrandPrixController;
use App\Http\Controllers\API\GrandPrix\GrandPrixListController;
use App\Http\Controllers\API\Checker\CheckerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Standings routes
Route::prefix("/standings")->controller(StandingsController::class)->group(function () {
    Route::get("/drivers/{season?}", "driverStandings")->name("standings.drivers");
    Route::get("/constructors/{season?}", "constructorStandings")->name("standings.constructors");
});

//Grand prix routes
Route::prefix("/grand-prix")->controller(GrandprixController::class)->group(function () {
    Route::get("/{name}/{season}", "getGrandPrix")->name("grand-prix.specific");
    Route::get("/latest", "getGrandPrix")->name("grand-prix.latest");
    Route::get("/latest-preview", "getGrandPrixPreview")->name("grand-prix.latest-preview");
});

//Driver routes
Route::prefix("/driver")->controller(DriverController::class)->group(function () {
    Route::get("/{name}", "getDriver")->name("driver.information");
});

//Constructor routes
Route::prefix("/constructor")->controller(ConstructorController::class)->group(function () {
    Route::get("/{name}", "getConstructor")->name("constructor.information");
});

//Circuit routes
Route::prefix("/circuit")->controller(CircuitController::class)->group(function () {
    Route::get("/{name}", "getCircuit")->name("circuit.information");
});

//Drivers list routes
Route::prefix("/drivers")->controller(DriverListController::class)->group(function () {
    Route::get("/", "getAllDrivers")->name("drivers.all");
    Route::get("/{season}", "getAllDriversBySeason")->name("alldrivers.by_season");
});

//Constructors list routes
Route::prefix("/constructors")->controller(ConstructorListController::class)->group(function () {
    Route::get("/", "getAllConstructors")->name("constructors.all");
    Route::get("/{season}", "getAllConstructorsBySeason")->name("allconstructors.by_season");
});

//Circuits list routes
Route::prefix("/circuits")->controller(CircuitListController::class)->group(function () {
    Route::get("/", "getAllCircuits")->name("circuits.all");
    Route::get("/{season}", "getAllCircuitsBySeason")->name("allcircuits.by_season");
});

//Grand Prix list schedule and information routes
Route::prefix("/grand-prix-list")->group(function () {
    Route::get("/next", [NextGrandPrixController::class, "getNextGrandPrix"])->name("grand-prix-list.next");
    Route::get("/current", [GrandPrixListController::class, "getCurrentSeasonRounds"])->name("grand-prix-list.current");
    Route::get("/season/{season?}", [GrandPrixListController::class, "getRoundsBySeason"])->name("grand-prix-list.by_season");
    Route::get("/name/{name}", [GrandPrixListController::class, "getRoundsByName"])->name("grand-prix-list.by_name");
});

//Laps times routes
Route::prefix("/lap-times")->controller(LapTimesController::class)->group(function () {
    Route::get("/{season}/{grandprix}/{driver}", "getLapTimes")->name("lap-times.driver");
});

//Race report routes
Route::prefix("/race-report")->controller(RaceReportController::class)->group(function () {
    Route::get("/{season}/{grandprix}/{driver}", "getRaceReport")->name("race-report.driver");
});

//Race report / lap times routes
Route::prefix("/analysis")->controller(AnalysisController::class)->group(function () {
    Route::get("/seasons", "getSeasons")->name("analysis.seasons");
    Route::get("/grand-prix/{season}", "getGrandPrix")->name("analysis.grand_prix");
    Route::get("/drivers/{season}/{grandprix}", "getDrivers")->name("analysis.drivers");
});

//Seasons list routes
Route::prefix("/seasons")->controller(SeasonController::class)->group(function () {
    Route::get("/", "getSeasons")->name("seasons.list");
});

//Checker list routes 
Route::prefix('/checker')->controller(CheckerController::class)->group(function () {
    Route::get('/season/{season}', 'checkSeason')->name('checker.season');
    Route::get('/grand-prix/{season}/{grandprix}', 'checkGrandPrix')->name('checker.grand_prix');
});
