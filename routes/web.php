<?php

use App\Http\Controllers\ComisionsController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CertificatesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PartiesController;
use App\Http\Controllers\PendingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\UsersController;
use App\Models\Pending;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=> false]);

Route::middleware(['auth', 'userStatus', 'isAdmin'])->group(function() {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(OrdersController::class)->group(function () {
        Route::get('ordenes', 'index')->name('order.index');
        Route::get('nuevaOrden', 'newOrder')->name('order.new');
        Route::post('guardarOrden', 'saveOrder')->name('order.save');
        Route::post('actualizarEstadoOrden', 'updateStatusOrder')->name('order.updateStatus');
        Route::get('darDeBajaUnaÓrden/{id}', 'disableOrder')->name('order.disable');
        Route::get('darDeAltaUnaÓrden/{id}', 'enableOrder')->name('order.enable');
        Route::get('listaDeÓrdenesDadasDeBaja', 'disabledOrders')->name('order.disabledList');
        Route::post('cambiarDueño', 'changeOrderOwner')->name('order.changeOwner');
        Route::post('editarDatos', 'updateOrder')->name('order.update');
        Route::post('cargarDocumento', 'loadDocumentOrder')->name('order.uploadDocument');
        Route::get('orden/eliminarDocumento/{id}', 'deleteDocumentOrder')->name('order.deleteDocument');
    });

    Route::controller(PartiesController::class)->group(function () {
        Route::get('partidos', 'index')->name('party.index');
        Route::post('nuevoPartido', 'newParty')->name('party.new');
        Route::get('añadirNuevoPartido','addNewParty')->name('party.newParty');
        Route::get('darDeBajaUnPartido/{id}', 'disableParty')->name('party.disableParty');
        Route::get('darDeAltaUnPartido/{id}', 'enableParty')->name('party.enableParty');
        Route::get('listaDePartidosDadosDeBaja', 'disabledParties')->name('party.disabledParties');
        Route::post('actualziarPartido/{id}', 'updateParty')->name('party.updateParty');
    });

    Route::controller(ComisionsController::class)->group(function () {
        Route::get('comisiones', 'index')->name('comision.index');
        Route::get('nuevaComision', 'newComision')->name('comision.new');
        Route::post('guardarComision', 'saveComision')->name('comision.save');
        //Route::get('detallesDeLaComisión/{id}', 'comisionsDetails')->name('comision.details');
        Route::get('darDeBajaComision/{id}', 'disableComision')->name('comision.disableComision');
        Route::get('darDeAltaComision/{id}', 'enableComision')->name('comision.enableComision');
        Route::get('listaDeComisionesDadasDeBaja', 'disabledComisions')->name('comision.disabledComisions');
        Route::post('actualizarComision', 'updateComision')->name('comision.updateComision');
        Route::post('añadirNuevoParticipante', 'addUserToComission')->name('comision.addUser');
        Route::post('cambiarPuesto', 'changePositionInComision')->name('comision.changePosition');
        Route::get('darDeBajaIntegrante/{id}', 'disableMemberFromComision')->name('comision.disableMember');
        Route::get('darDeAltaIntegrante/{id}', 'enableMemberFromComision')->name('comision.enableMember');
        Route::get('historialDeLasComisiones', 'comisionsRecordsList')->name('comision.recordsList');
        Route::get('historialDeLasComisiones/{id}', 'comisionsRecords')->name('comision.records');
        Route::post('AJAX/listaDeComisiones', 'comisionsListAJAX')->name('comision.AJAXComisionList');
    });

    Route::controller(UsersController::class)->group(function () {
        Route::get('usuarios', 'index')->name('users.index');
        Route::get('nuevoUsuario', 'newUser')->name('user.new');
        Route::post('guardarUsuario', 'saveUser')->name('user.save');
        Route::get('darDeBajaUsuario/{id}', 'disableUser')->name('user.disable');
        Route::get('darDeAltaUsuario/{id}', 'enableUser')->name('user.enable');
        Route::post('cambiarContraseñaUsuario', 'changeUserPass')->name('user.changeUserPass');
        Route::get('usuariosDadosDeBaja', 'disabledUsers')->name('user.disabledUsers');
        Route::post('actualizarUsuario', 'updateUser')->name('user.update');
        Route::get('mandarDatosPredial', 'predialSendData')->name('user.predial');
    });

    Route::controller(ContentController::class)->group(function () {
        Route::get('contenido/orden/{order_id}', 'newContent')->name('content.index');
        Route::post('guardarContenido/{order_id}', 'saveContent')->name('content.save');
        Route::get('eliminarDocumento/{content_id}', 'deleteDocumentContent')->name('content.deleteDocument');
        Route::get('eliminarSubDocumento/{content_id}', 'deleteSubDocumentContent')->name('subcontent.deleteDocument');
        Route::post('guardarDocumentoContenido', 'saveDocumentContent')->name('content.saveDocument');
        Route::post('guardarDocumentoSubcontenido', 'saveDocumentSubcontent')->name('subcontent.saveDocument');
        Route::post('subirPrioridadContenido', 'ajaxUpCPriority')->name('content.ajaxUpP');
        Route::post('bajarPrioridadContenido', 'ajaxDownCPriority')->name('content.ajaxDownP');
        Route::post('subirPrioridadSubcontenido', 'ajaxUpSCPriority')->name('subcontent.ajaxUpCP');
        Route::post('bajarPrioridadSubcontenido', 'ajaxDownSCPriority')->name('subcontent.ajaxDownCP');
        Route::get('añadirNuevoContenido/{order_id}', 'addNewContent')->name('content.newContent');
        Route::get('añadirNuevoSubcontenido/{order_id}', 'addNewSubcontent')->name('subcontent.newSubcontent');
        Route::post('guardarNuevoContenido', 'saveNewContent')->name('content.saveNewContent');
        Route::post('guardarNuevoSubcontenido', 'saveNewSubcontent')->name('subcontent.saveNewSubcontent');
        Route::post('actualizarContenido', 'updateContent')->name('content.updateDescription');
        Route::post('actualizarSubcontenido', 'updateSubcontent')->name('subcontent.updateDescription');
        Route::post('dehabilitarContenido/{content_id}', 'disableContent')->name('content.disable');
        Route::post('dehabilitarSubcontenido/{subcontent_id}', 'disableSubcontent')->name('subcontent.disable');
        
    });

    Route::controller(RecordsController::class)->group(function () {
        Route::get('historial/comisión/{id}', 'showRecords')->name('records.showRecords');
    });

    Route::controller(CertificatesController::class)->group(function () {
        Route::get('añadirNuevaActa', 'newCertificates')->name('certificates.newCertificate');
        Route::post('guardarNuevaActa', 'saveCertificates')->name('certificates.saveNew');
        Route::get('deshabilitarActa/{id}', 'disableCertificates')->name('certificates.disable');
        Route::get('habilitarActa/{id}', 'enableCertificates')->name('certificates.enable');
        Route::get('ListaDeActasDeshabilitadas', 'disabledCertificatesList')->name('certificates.disabledList');
        Route::post('editarActa', 'editCertificate')->name('certificate.edit');
        Route::post('AJAX/listaDeOrdenes', 'AJAXOrdersList')->name('certificate.AJAXgetOrders');
    });

    Route::controller(PendingController::class)->group(function () {
        Route::get('añadirNuevoPendiente', 'newPending')->name('pending.newPending');
        Route::post('guardarNuevoPendiente', 'saveNewPending')->name('pending.saveNew');
        Route::get('darDeBajaPendiente/{id}', 'disablePending')->name('pending.disable');
        Route::get('darDeAltaPendiente/{id}', 'enablePending')->name('pending.enable');
        Route::get('listaDePendientesDadosDeBaja', 'disabledPendingsList')->name('pending.disabledList');
        Route::post('actualizarPendiente', 'updatePending')->name('pending.update');
        Route::get('AJAX/obtenerÓrdenes', 'pendingGetOrders')->name('pending.getOrders');
        Route::get('AJAX/obtenerContenido/{id}', 'pendingGetContent')->name('pending.getContent');
        Route::post('cargarPendienteEnLaOrden', 'loadPending')->name('pending.loadPending');
    });
});

Route::middleware(['auth', 'userStatus'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::controller(OrdersController::class)->group(function () {
        Route::get('RI/ordenes', 'iRIndex')->name('order.iRIndex');
    });

    Route::controller(UsersController::class)->group(function () {
        Route::get('cambiarContraseña', 'changePass')->name('users.changePass');
        Route::post('guardarContraseña', 'saveNewPass')->name('user.saveNewPass');
    });

    Route::controller(ComisionsController::class)->group(function () {
        Route::get('comisiones', 'index')->name('comision.index');
        Route::get('detallesDeLaComisión/{id}', 'comisionsDetails')->name('comision.details');
    });

    Route::controller(ContentController::class)->group(function () {
        Route::get('orden/contenido/{order_id}', 'internalReviewContent')->name('content.IRIndex');
    });

    Route::controller(CertificatesController::class)->group(function () {
        Route::get('listaDeActas', 'index')->name('certificates.index');
        Route::get('listaDeActas/busqueda/{text}', 'indexSearch')->name('certificates.indexSearch');
    });

    Route::controller(PendingController::class)->group(function () {
        Route::get('listaDePuntosPendientes', 'index')->name('pending.index');
        Route::get('listaDePendientesAceptados', 'aceptedPendingsList')->name('pending.aceptedList');
        Route::get('listaDePendientesRechazados', 'rejectedPendingsList')->name('pending.rejectedList');
    });
});



Route::controller(OrdersController::class)->group(function () {
    Route::get('Vista/ordenes/ordinarias', 'GPHCOOrdersView')->name('orders.GPHCOOrdersView');
    Route::get('Vista/ordenes/extraordinarias', 'GPHCEOOrdersView')->name('orders.GPHCEOOrdersView');
    Route::get('Vista/ordenes/solemnes', 'GPHCSOrdersView')->name('orders.GPHCSOrdersView');
    Route::get('Vista/ordenes/comisiones', 'GPCOrdersView')->name('orders.GPCOrdersView');
});

Route::controller(ContentController::class)->group(function () {
    Route::get('Vista/contenido/orden/{order_id}', 'GPViewContent')->name('content.GPindex');
});

Route::controller(ComisionsController::class)->group(function () {
    Route::get('Vista/comisiones/lista', 'GPViewComisions')->name('comision.GPindex');
    Route::get('Vista/comisiones/detalles/{id}', 'GPcomisionsDetails')->name('comision.GPdetails');
    Route::get('Vista/participaciones/{comision_name}', 'GPComisionRecords')->name('comision.GPRecords');
});

Route::controller(CertificatesController::class)->group(function () {
    Route::get('Vista/actas/lista', 'GPindex')->name('certificates.GPindex');
});