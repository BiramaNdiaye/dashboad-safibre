<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TachesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AccueilController;
   use App\Http\Controllers\FrontalController;
use App\Http\Controllers\EtudeController;
use App\Http\Controllers\PatatoideController;
use App\Http\Controllers\FCINexloopController;
use App\Http\Controllers\EtudeFaisabiController;
use App\Http\Controllers\BloController;

use App\Http\Controllers\CommandeController;
// Routes publiques (ex. accueil et auth)
Route::get('/', fn () => view('welcome'));
Auth::routes();
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->middleware(['auth', 'role:admin']) // Restriction d’accès à l’enregistrement
    ->name('register');

// Routes protégées par auth
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    //  Routes projets
    Route::get('/projets', [ProjetController::class, 'index'])->middleware('role:admin|operation|Manager')->name('projets.index');
    Route::get('/creer-projet', [ProjetController::class, 'create'])->middleware('role:admin|operation|Manager')->name('projets.create');
    Route::post('/creer-projet', [ProjetController::class, 'store'])->middleware('role:admin|operation|Manager')->name('projets.store');
    Route::get('projets/{id}/edit', [ProjetController::class, 'edit'])->middleware('role:admin|Manager|operation')->name('projets.edit');
    Route::get('/projets/{id}', [ProjetController::class, 'show'])->name('projets.show');
    Route::put('projets/{id}', [ProjetController::class, 'update'])->name('projets.update');
    Route::delete('/projets/{id}', [ProjetController::class, 'destroy'])->name('projets.destroy');
    Route::get('projets/{projet}/tache', [ProjetController::class, 'showTaches'])->middleware('role:admin|operation|Manager')->name('projets.taches.index');
    Route::get('/projets-filter', [ProjetController::class, 'filter'])->name('projets.filter');
    Route::get('/projets-search', [ProjetController::class, 'search'])->name('projets.search');
    Route::get('/projets-export', [ProjetController::class, 'exportExcel'])->name('projets.export');
    Route::get('/projets-evolution', [ProjetController::class, 'evolutionMensuelle'])->name('projets.evolution');
    Route::get('/mes-projets', [ProjetController::class, 'mesProjets'])->name('projets.mes-projets');
    Route::get('/mes-projets-prestataires', [ProjetController::class, 'projetsPrestaire'])->name('mes-projets-prestataires');
    Route::post('/projets/changeStatus', [ProjetController::class, 'bulkUpdateStatus'])->name('projets.changeStatus');

    // Tâches
    Route::get('/taches/{projet}', [TachesController::class, 'create'])->middleware('role:admin|operation|Manager')->name('taches.create');
    Route::post('/taches', [TachesController::class, 'store'])->middleware('role:admin|operation|Manager')->name('taches.store');
    Route::get('taches/{id}/edit', [TachesController::class, 'edit'])->middleware('role:admin|operation|Manager')->name('taches.edit');
    Route::put('taches/{id}', [TachesController::class, 'update'])->name('taches.update');
    Route::delete('/taches/{id}', [TachesController::class, 'destroy'])->middleware('role:admin|operation|Manager')->name('taches.destroy');
    Route::get('/taches/filter', [TachesController::class, 'filter'])->name('taches.filter');
    Route::get('/corbeille-rop', [TachesController::class, 'afficheRop'])->name('taches.afficheRop');
    Route::get('/corbeille-blo', [TachesController::class, 'afficheBlo'])->name('taches.afficheBlo');
    Route::get('/accompagnements', [TachesController::class, 'listeAccompagnements'])->name('accompagnements.index');
    Route::get('/doe', [TachesController::class, 'listeDOE'])->name('doe.index');
    Route::get('/productionAPD', [TachesController::class, 'listeAPD'])->name('prodApd.index');
    Route::get('/projets/{reference}/taches', [TachesController::class, 'index'])->name('projets.taches');
    Route::get('/projets/rop/export', [TachesController::class, 'exportRop'])->name('projets.rop.export');
    Route::get('/doe/export', [TachesController::class, 'exportDoe'])->name('doe.export');
    // Clients
    Route::get('/clients', [ClientsController::class, 'index'])->middleware('role:admin')->name('clients.index');
    Route::get('/creer-clients', [ClientsController::class, 'create'])->middleware('role:admin')->name('clients.create');
    Route::post('/creer-clients', [ClientsController::class, 'store'])->middleware('role:admin')->name('clients.store');
    Route::get('clients/{id}/edit', [ClientsController::class, 'edit'])->middleware('role:admin')->name('clients.edit');
    Route::put('clients/{id}', [ClientsController::class, 'update'])->middleware('role:admin')->name('clients.update');
    Route::delete('/clients/{id}', [ClientsController::class, 'destroy'])->middleware('role:admin')->name('clients.destroy');

    //  Utilisateurs
    Route::get('/users', [UserController::class, 'index'])->middleware('role:admin')->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->middleware('role:admin')->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->middleware('role:admin')->name('users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->middleware('role:admin')->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->middleware('role:admin')->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('role:admin')->name('users.destroy');

    //  Rôles et permissions
    Route::get('/roles/assign/{id}', [RoleController::class, 'assignRole'])->middleware('role:admin')->name('roles.assign');
    Route::post('/roles/store', [RoleController::class, 'storeRole'])->middleware('role:admin')->name('roles.store');
    Route::get('/permissions', [PermissionController::class, 'index'])->middleware('role:admin')->name('permissions.index');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->middleware('role:admin')->name('permissions.store');

    //  Statistiques
    Route::get('/statistiques', [StatistiqueController::class, 'index'])->middleware('role:admin')->name('statistiques.index');
    Route::get('/evolution-projet', [StatistiqueController::class, 'evolutionMensuelle'])->middleware('role:admin')->name('statistiques.evolution-projet');
     Route::get('/rapports/rop-operateurs', [TachesController::class, 'ropParOperateur'])
    ->name('rapports.rop-operateurs');
    Route::get('/kpi/rop/export', [TachesController::class, 'exportRopParOperateur'])->name('kpi.rop.export');
    Route::get('/rop-graph', [TachesController::class, 'showRopGraph'])->name('rop.graph.index');
    
    Route::get('/accueil', [AccueilController::class, 'index'])->name('accueil')->middleware('auth');

    Route::get('/etudes/create', [EtudeController::class, 'create'])->name('etudes.create');
Route::post('/etudes', [EtudeController::class, 'store'])->name('etudes.store');
Route::get('/etudes', [EtudeController::class, 'index'])->name('etudes.index');
Route::get('/etudes/{etude}/edit', [EtudeController::class, 'edit'])->name('etudes.edit');
Route::put('/etudes/{etude}', [EtudeController::class, 'update'])->name('etudes.update');
Route::get('/etudes/search-result', [EtudeController::class, 'search'])->name('etudes.search');


Route::get('/frontals/create', [FrontalController::class, 'create'])->name('frontals.create');
Route::post('/frontals', [FrontalController::class, 'store'])->name('frontals.store');
Route::get('/frontals', [FrontalController::class, 'index'])->name('frontals.index');
Route::get('/frontals/{frontal}/edit', [FrontalController::class, 'edit'])->name('frontals.edit');
Route::put('/frontals/{frontal}', [FrontalController::class, 'update'])->name('frontals.update');

Route::get('/patatoides', [PatatoideController::class, 'index'])->name('patatoides.index');
Route::get('/patatoides/create', [PatatoideController::class, 'create'])->name('patatoides.create');
Route::post('/patatoides', [PatatoideController::class, 'store'])->name('patatoides.store');
Route::get('/patatoides/{patatoide}/edit', [PatatoideController::class, 'edit'])->name('patatoides.edit');
Route::put('/patatoides/{patatoide}', [PatatoideController::class, 'update'])->name('patatoides.update');
Route::delete('/patatoides/{patatoide}', [PatatoideController::class, 'destroy'])->name('patatoides.destroy');
Route::get('/patatoides/{patatoide}', [PatatoideController::class, 'show'])->name('patatoides.show');
Route::post('/patatoides/import', [PatatoideController::class, 'importCsv'])
    ->name('patatoides.import');


Route::get('/etudes-faisabilite', [EtudeFaisabiController::class, 'index'])->name('nexloop.etudes.index');
Route::get('/etudes-faisabilite/create', [EtudeFaisabiController::class, 'create'])->name('nexloop.etudes.create');
Route::post('/etudes-faisabilite', [EtudeFaisabiController::class, 'store'])->name('etudes-faisabilite.store');
Route::get('/etudes-faisabilite/{id}/edit', [EtudeFaisabiController::class, 'edit'])->name('nexloop.etudes.edit');
Route::put('/etudes-faisabilite/{id}', [EtudeFaisabiController::class, 'update'])->name('nexloop.etudes.update');
Route::delete('/etudes-faisabilite/{id}', [EtudeFaisabiController::class, 'destroy'])->name('nexloop.etudes.destroy');


Route::get('/fci-nexloop', [FCINexloopController::class, 'index'])->name('nexloop.fci.index');
Route::get('/fci-nexloop/create', [FCINexloopController::class, 'create'])->name('nexloop.fci.create');
Route::post('/fci-nexloop', [FCINexloopController::class, 'store'])->name('fci-nexloop.store');
Route::get('/fci-nexloop/{id}/edit', [FCINexloopController::class, 'edit'])->name('nexloop.fci.edit');
Route::put('/fci-nexloop/{id}', [FCINexloopController::class, 'update'])->name('nexloop.fci.update');
Route::delete('/fci-nexloop/{patatoide}', [FCINexloopController::class, 'destroy'])->name('nexloop.fci.destroy');
 Route::get('/fci-nexloop/{id}', [FCINexloopController::class, 'show'])->name('nexloop.fci.show');

Route::get('/etudesfa/search-result', [EtudeFaisabiController::class, 'search'])->name('etudes.search');
    Route::get('/export-patatoides', [App\Http\Controllers\PatatoideController::class, 'export'])->name('patatoides.export');

    Route::get('/blo-nexloop', [BloController::class, 'afficheBloNexloop'])->name('blo.nexloop');
Route::get('/blo-mcconnect', [BloController::class, 'afficheBloMcConnect'])->name('blo.mcconnect');

Route::get('/rop-graph/export', [TachesController::class, 'exportRopGraph'])->name('rop.graph.export');

Route::resource('commandes', CommandeController::class);
Route::get(
    '/commandes/export/excel',
    [CommandeController::class, 'exportExcel']
)->name('commandes.export.excel');
});
