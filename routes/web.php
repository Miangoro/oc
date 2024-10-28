<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Crm;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\layouts\CollapsedMenu;
use App\Http\Controllers\layouts\ContentNavbar;
use App\Http\Controllers\layouts\ContentNavSidebar;
use App\Http\Controllers\layouts\Horizontal;
use App\Http\Controllers\layouts\Vertical;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\front_pages\Landing;
use App\Http\Controllers\front_pages\Pricing;
use App\Http\Controllers\front_pages\Payment;
use App\Http\Controllers\front_pages\Checkout;
use App\Http\Controllers\front_pages\HelpCenter;
use App\Http\Controllers\front_pages\HelpCenterArticle;
use App\Http\Controllers\apps\Email;
use App\Http\Controllers\apps\Chat;
use App\Http\Controllers\apps\Calendar;
use App\Http\Controllers\apps\Kanban;
use App\Http\Controllers\apps\EcommerceDashboard;
use App\Http\Controllers\apps\EcommerceProductList;
use App\Http\Controllers\apps\EcommerceProductAdd;
use App\Http\Controllers\apps\EcommerceProductCategory;
use App\Http\Controllers\apps\EcommerceOrderList;
use App\Http\Controllers\apps\EcommerceOrderDetails;
use App\Http\Controllers\apps\EcommerceCustomerAll;
use App\Http\Controllers\apps\EcommerceCustomerDetailsOverview;
use App\Http\Controllers\apps\EcommerceCustomerDetailsSecurity;
use App\Http\Controllers\apps\EcommerceCustomerDetailsBilling;
use App\Http\Controllers\apps\EcommerceCustomerDetailsNotifications;
use App\Http\Controllers\apps\EcommerceManageReviews;
use App\Http\Controllers\apps\EcommerceReferrals;
use App\Http\Controllers\apps\EcommerceSettingsDetails;
use App\Http\Controllers\apps\EcommerceSettingsPayments;
use App\Http\Controllers\apps\EcommerceSettingsCheckout;
use App\Http\Controllers\apps\EcommerceSettingsShipping;
use App\Http\Controllers\apps\EcommerceSettingsLocations;
use App\Http\Controllers\apps\EcommerceSettingsNotifications;
use App\Http\Controllers\apps\AcademyDashboard;
use App\Http\Controllers\apps\AcademyCourse;
use App\Http\Controllers\apps\AcademyCourseDetails;
use App\Http\Controllers\apps\LogisticsDashboard;
use App\Http\Controllers\apps\LogisticsFleet;
use App\Http\Controllers\apps\InvoiceList;
use App\Http\Controllers\apps\InvoicePreview;
use App\Http\Controllers\apps\InvoicePrint;
use App\Http\Controllers\apps\InvoiceEdit;
use App\Http\Controllers\apps\InvoiceAdd;
use App\Http\Controllers\apps\UserList;
use App\Http\Controllers\apps\UserViewAccount;
use App\Http\Controllers\apps\UserViewSecurity;
use App\Http\Controllers\apps\UserViewBilling;
use App\Http\Controllers\apps\UserViewNotifications;
use App\Http\Controllers\apps\UserViewConnections;
use App\Http\Controllers\apps\AccessRoles;
use App\Http\Controllers\apps\AccessPermission;
use App\Http\Controllers\pages\UserProfile;
use App\Http\Controllers\pages\UserTeams;
use App\Http\Controllers\pages\UserProjects;
use App\Http\Controllers\pages\UserConnections;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsSecurity;
use App\Http\Controllers\pages\AccountSettingsBilling;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\Faq;
use App\Http\Controllers\pages\Pricing as PagesPricing;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\HologramasValidacion;

use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\pages\MiscComingSoon;
use App\Http\Controllers\pages\MiscNotAuthorized;
use App\Http\Controllers\pages\MiscServerError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\LoginCover;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\RegisterCover;
use App\Http\Controllers\authentications\RegisterMultiSteps;
use App\Http\Controllers\authentications\VerifyEmailBasic;
use App\Http\Controllers\authentications\VerifyEmailCover;
use App\Http\Controllers\authentications\ResetPasswordBasic;
use App\Http\Controllers\authentications\ResetPasswordCover;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\ForgotPasswordCover;
use App\Http\Controllers\authentications\TwoStepsBasic;
use App\Http\Controllers\authentications\TwoStepsCover;
use App\Http\Controllers\wizard_example\Checkout as WizardCheckout;
use App\Http\Controllers\wizard_example\PropertyListing;
use App\Http\Controllers\wizard_example\CreateDeal;
use App\Http\Controllers\modal\ModalExample;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\cards\CardAdvance;
use App\Http\Controllers\cards\CardStatistics;
use App\Http\Controllers\cards\CardAnalytics;
use App\Http\Controllers\cards\CardGamifications;
use App\Http\Controllers\cards\CardActions;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\Avatar;
use App\Http\Controllers\extended_ui\BlockUI;
use App\Http\Controllers\extended_ui\DragAndDrop;
use App\Http\Controllers\extended_ui\MediaPlayer;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\StarRatings;
use App\Http\Controllers\extended_ui\SweetAlert;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\extended_ui\TimelineBasic;
use App\Http\Controllers\extended_ui\TimelineFullscreen;
use App\Http\Controllers\extended_ui\Tour;
use App\Http\Controllers\extended_ui\Treeview;
use App\Http\Controllers\extended_ui\Misc;
use App\Http\Controllers\icons\RiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_elements\CustomOptions;
use App\Http\Controllers\form_elements\Editors;
use App\Http\Controllers\form_elements\FileUpload;
use App\Http\Controllers\form_elements\Picker;
use App\Http\Controllers\form_elements\Selects;
use App\Http\Controllers\form_elements\Sliders;
use App\Http\Controllers\form_elements\Switches;
use App\Http\Controllers\form_elements\Extras;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\form_layouts\StickyActions;
use App\Http\Controllers\form_wizard\Numbered as FormWizardNumbered;
use App\Http\Controllers\form_wizard\Icons as FormWizardIcons;
use App\Http\Controllers\form_validation\Validation;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\tables\DatatableBasic;
use App\Http\Controllers\tables\DatatableAdvanced;
use App\Http\Controllers\tables\DatatableExtensions;
use App\Http\Controllers\charts\ApexCharts;
use App\Http\Controllers\charts\ChartJs;
use App\Http\Controllers\maps\Leaflet;
use App\Http\Controllers\solicitudCliente\solicitudClienteController;
use App\Http\Controllers\pdfscontrollers\CartaAsignacionController;
use App\Http\Controllers\EnviarCorreoController;
use App\Http\Controllers\clientes\clientesProspectoController;
use App\Http\Controllers\catalogo\categoriasController;
use App\Http\Controllers\catalogo\marcasCatalogoController;
use App\Http\Controllers\catalogo\ClaseController;
use App\Http\Controllers\catalogo\lotesEnvasadoController;
use App\Http\Controllers\guias\GuiasController;
use App\Http\Controllers\hologramas\solicitudHologramaController;
use App\Http\Controllers\clientes\clientesConfirmadosController;
use App\Http\Controllers\documentacion\documentacionController;
use App\Http\Controllers\domicilios\DomiciliosController;
use App\Http\Controllers\domicilios\prediosController;
use App\Http\Controllers\domicilios\DestinosController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\getFuncionesController;
use App\Http\Controllers\usuarios\UsuariosController;
use App\Http\Controllers\usuarios\UsuariosInspectoresController;
use App\Http\Controllers\usuarios\UsuariosPersonalController;
use App\Http\Controllers\usuarios\UsuariosConsejoController;
use App\Http\Controllers\catalogo\LotesGranelController;
use App\Http\Controllers\documentacion\DocumentosController;
use App\Http\Controllers\solicitudes\SolicitudesTipoController;
//Tipos maguey/agave
use App\Http\Controllers\catalogo\tiposController;
use App\Http\Controllers\dictamenes\InstalacionesController;
use App\Http\Controllers\dictamenes\DictamenGranelController;
use App\Http\Controllers\dictamenes\DictamenEnvasadoController;
use App\Http\Controllers\certificados\Certificado_InstalacionesController;
use App\Http\Controllers\hologramas\solicitudHolograma;
use App\Http\Controllers\catalogo\catalogoEquiposController;
use App\Http\Controllers\inspecciones\inspeccionesController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\solicitudes\solicitudesController;
use App\Http\Controllers\TrazabilidadController;
use App\Http\Controllers\pdf_llenado\PdfController;
use App\Http\Controllers\revision\RevisionPersonalController;
use App\Http\Controllers\revision\catalogo_personal_seleccion_preguntas_controller;

// Main Page Route
//Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/', function () {
    return redirect('/login');
});

//Para documentos
Route::get('files/{filename}', [FileController::class, 'show'])
    ->name('file.show')
    ->middleware('auth'); // Middleware para autenticar usuarios

    Route::get('files/{carpeta}/{filename}', [FileController::class, 'show2'])
    ->name('file.show2')
    ->middleware('auth'); // Middleware para autenticar usuarios

Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/dashboard/crm', [Crm::class, 'index'])->name('dashboard-crm');
// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

// layout
Route::get('/layouts/collapsed-menu', [CollapsedMenu::class, 'index'])->name('layouts-collapsed-menu');
Route::get('/layouts/content-navbar', [ContentNavbar::class, 'index'])->name('layouts-content-navbar');
Route::get('/layouts/content-nav-sidebar', [ContentNavSidebar::class, 'index'])->name('layouts-content-nav-sidebar');
Route::get('/layouts/horizontal', [Horizontal::class, 'index'])->name('dashboard-analytics');
Route::get('/layouts/vertical', [Vertical::class, 'index'])->name('dashboard-analytics');
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// Front Pages
Route::get('/front-pages/landing', [Landing::class, 'index'])->name('front-pages-landing');
Route::get('/front-pages/pricing', [Pricing::class, 'index'])->name('front-pages-pricing');
Route::get('/front-pages/payment', [Payment::class, 'index'])->name('front-pages-payment');
Route::get('/front-pages/checkout', [Checkout::class, 'index'])->name('front-pages-checkout');
Route::get('/front-pages/help-center', [HelpCenter::class, 'index'])->name('front-pages-help-center');
Route::get('/front-pages/help-center-article', [HelpCenterArticle::class, 'index'])->name('front-pages-help-center-article');

// apps
Route::get('/app/email', [Email::class, 'index'])->name('app-email');
Route::get('/app/chat', [Chat::class, 'index'])->name('app-chat');
Route::get('/app/calendar', [Calendar::class, 'index'])->name('app-calendar');
Route::get('/app/kanban', [Kanban::class, 'index'])->name('app-kanban');
Route::get('/app/ecommerce/dashboard', [EcommerceDashboard::class, 'index'])->name('app-ecommerce-dashboard');
Route::get('/app/ecommerce/product/list', [EcommerceProductList::class, 'index'])->name('app-ecommerce-product-list');
Route::get('/app/ecommerce/product/add', [EcommerceProductAdd::class, 'index'])->name('app-ecommerce-product-add');
Route::get('/app/ecommerce/product/category', [EcommerceProductCategory::class, 'index'])->name('app-ecommerce-product-category');
Route::get('/app/ecommerce/order/list', [EcommerceOrderList::class, 'index'])->name('app-ecommerce-order-list');
Route::get('/app/ecommerce/order/details', [EcommerceOrderDetails::class, 'index'])->name('app-ecommerce-order-details');
Route::get('/app/ecommerce/customer/all', [EcommerceCustomerAll::class, 'index'])->name('app-ecommerce-customer-all');
Route::get('/app/ecommerce/customer/details/overview', [EcommerceCustomerDetailsOverview::class, 'index'])->name('app-ecommerce-customer-details-overview');
Route::get('/app/ecommerce/customer/details/security', [EcommerceCustomerDetailsSecurity::class, 'index'])->name('app-ecommerce-customer-details-security');
Route::get('/app/ecommerce/customer/details/billing', [EcommerceCustomerDetailsBilling::class, 'index'])->name('app-ecommerce-customer-details-billing');
Route::get('/app/ecommerce/customer/details/notifications', [EcommerceCustomerDetailsNotifications::class, 'index'])->name('app-ecommerce-customer-details-notifications');
Route::get('/app/ecommerce/manage/reviews', [EcommerceManageReviews::class, 'index'])->name('app-ecommerce-manage-reviews');
Route::get('/app/ecommerce/referrals', [EcommerceReferrals::class, 'index'])->name('app-ecommerce-referrals');
Route::get('/app/ecommerce/settings/details', [EcommerceSettingsDetails::class, 'index'])->name('app-ecommerce-settings-details');
Route::get('/app/ecommerce/settings/payments', [EcommerceSettingsPayments::class, 'index'])->name('app-ecommerce-settings-payments');
Route::get('/app/ecommerce/settings/checkout', [EcommerceSettingsCheckout::class, 'index'])->name('app-ecommerce-settings-checkout');
Route::get('/app/ecommerce/settings/shipping', [EcommerceSettingsShipping::class, 'index'])->name('app-ecommerce-settings-shipping');
Route::get('/app/ecommerce/settings/locations', [EcommerceSettingsLocations::class, 'index'])->name('app-ecommerce-settings-locations');
Route::get('/app/ecommerce/settings/notifications', [EcommerceSettingsNotifications::class, 'index'])->name('app-ecommerce-settings-notifications');
Route::get('/app/academy/dashboard', [AcademyDashboard::class, 'index'])->name('app-academy-dashboard');
Route::get('/app/academy/course', [AcademyCourse::class, 'index'])->name('app-academy-course');
Route::get('/app/academy/course-details', [AcademyCourseDetails::class, 'index'])->name('app-academy-course-details');
Route::get('/app/logistics/dashboard', [LogisticsDashboard::class, 'index'])->name('app-logistics-dashboard');
Route::get('/app/logistics/fleet', [LogisticsFleet::class, 'index'])->name('app-logistics-fleet');
Route::get('/app/invoice/list', [InvoiceList::class, 'index'])->name('app-invoice-list');
Route::get('/app/invoice/preview', [InvoicePreview::class, 'index'])->name('app-invoice-preview');
Route::get('/app/invoice/print', [InvoicePrint::class, 'index'])->name('app-invoice-print');
Route::get('/app/invoice/edit', [InvoiceEdit::class, 'index'])->name('app-invoice-edit');
Route::get('/app/invoice/add', [InvoiceAdd::class, 'index'])->name('app-invoice-add');
Route::get('/app/user/list', [UserList::class, 'index'])->name('app-user-list');
Route::get('/app/user/view/account', [UserViewAccount::class, 'index'])->name('app-user-view-account');
Route::get('/app/user/view/security', [UserViewSecurity::class, 'index'])->name('app-user-view-security');
Route::get('/app/user/view/billing', [UserViewBilling::class, 'index'])->name('app-user-view-billing');
Route::get('/app/user/view/notifications', [UserViewNotifications::class, 'index'])->name('app-user-view-notifications');
Route::get('/app/user/view/connections', [UserViewConnections::class, 'index'])->name('app-user-view-connections');
Route::get('/app/access-roles', [AccessRoles::class, 'index'])->name('app-access-roles');
Route::get('/app/access-permission', [AccessPermission::class, 'index'])->name('app-access-permission');

// pages
Route::get('/pages/profile-user', [UserProfile::class, 'index'])->name('pages-profile-user');
Route::get('/pages/profile-teams', [UserTeams::class, 'index'])->name('pages-profile-teams');
Route::get('/pages/profile-projects', [UserProjects::class, 'index'])->name('pages-profile-projects');
Route::get('/pages/profile-connections', [UserConnections::class, 'index'])->name('pages-profile-connections');
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-security', [AccountSettingsSecurity::class, 'index'])->name('pages-account-settings-security');
Route::get('/pages/account-settings-billing', [AccountSettingsBilling::class, 'index'])->name('pages-account-settings-billing');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/faq', [Faq::class, 'index'])->name('pages-faq');
Route::get('/pages/pricing', [PagesPricing::class, 'index'])->name('pages-pricing');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/hologramas-validacion/{folio}', [HologramasValidacion::class, 'index'])->name('pages-hologramas-validacion');

Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
Route::get('/pages/misc-comingsoon', [MiscComingSoon::class, 'index'])->name('pages-misc-comingsoon');
Route::get('/pages/misc-not-authorized', [MiscNotAuthorized::class, 'index'])->name('pages-misc-not-authorized');
Route::get('/pages/misc-server-error', [MiscServerError::class, 'index'])->name('pages-misc-server-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/login-cover', [LoginCover::class, 'index'])->name('auth-login-cover');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/register-cover', [RegisterCover::class, 'index'])->name('auth-register-cover');
Route::get('/auth/register-multisteps', [RegisterMultiSteps::class, 'index'])->name('auth-register-multisteps');
Route::get('/auth/verify-email-basic', [VerifyEmailBasic::class, 'index'])->name('auth-verify-email-basic');
Route::get('/auth/verify-email-cover', [VerifyEmailCover::class, 'index'])->name('auth-verify-email-cover');
Route::get('/auth/reset-password-basic', [ResetPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::get('/auth/reset-password-cover', [ResetPasswordCover::class, 'index'])->name('auth-reset-password-cover');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::get('/auth/forgot-password-cover', [ForgotPasswordCover::class, 'index'])->name('auth-forgot-password-cover');
Route::get('/auth/two-steps-basic', [TwoStepsBasic::class, 'index'])->name('auth-two-steps-basic');
Route::get('/auth/two-steps-cover', [TwoStepsCover::class, 'index'])->name('auth-two-steps-cover');

// wizard example
Route::get('/wizard/ex-checkout', [WizardCheckout::class, 'index'])->name('wizard-ex-checkout');
Route::get('/wizard/ex-property-listing', [PropertyListing::class, 'index'])->name('wizard-ex-property-listing');
Route::get('/wizard/ex-create-deal', [CreateDeal::class, 'index'])->name('wizard-ex-create-deal');

// modal
Route::get('/modal-examples', [ModalExample::class, 'index'])->name('modal-examples');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');
Route::get('/cards/advance', [CardAdvance::class, 'index'])->name('cards-advance');
Route::get('/cards/statistics', [CardStatistics::class, 'index'])->name('cards-statistics');
Route::get('/cards/analytics', [CardAnalytics::class, 'index'])->name('cards-analytics');
Route::get('/cards/gamifications', [CardGamifications::class, 'index'])->name('cards-gamifications');
Route::get('/cards/actions', [CardActions::class, 'index'])->name('cards-actions');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-avatar', [Avatar::class, 'index'])->name('extended-ui-avatar');
Route::get('/extended/ui-blockui', [BlockUI::class, 'index'])->name('extended-ui-blockui');
Route::get('/extended/ui-drag-and-drop', [DragAndDrop::class, 'index'])->name('extended-ui-drag-and-drop');
Route::get('/extended/ui-media-player', [MediaPlayer::class, 'index'])->name('extended-ui-media-player');
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-star-ratings', [StarRatings::class, 'index'])->name('extended-ui-star-ratings');
Route::get('/extended/ui-sweetalert2', [SweetAlert::class, 'index'])->name('extended-ui-sweetalert2');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');
Route::get('/extended/ui-timeline-basic', [TimelineBasic::class, 'index'])->name('extended-ui-timeline-basic');
Route::get('/extended/ui-timeline-fullscreen', [TimelineFullscreen::class, 'index'])->name('extended-ui-timeline-fullscreen');
Route::get('/extended/ui-tour', [Tour::class, 'index'])->name('extended-ui-tour');
Route::get('/extended/ui-treeview', [Treeview::class, 'index'])->name('extended-ui-treeview');
Route::get('/extended/ui-misc', [Misc::class, 'index'])->name('extended-ui-misc');

// icons
Route::get('/icons/icons-ri', [RiIcons::class, 'index'])->name('icons-ri');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');
Route::get('/forms/custom-options', [CustomOptions::class, 'index'])->name('forms-custom-options');
Route::get('/forms/editors', [Editors::class, 'index'])->name('forms-editors');
Route::get('/forms/file-upload', [FileUpload::class, 'index'])->name('forms-file-upload');
Route::get('/forms/pickers', [Picker::class, 'index'])->name('forms-pickers');
Route::get('/forms/selects', [Selects::class, 'index'])->name('forms-selects');
Route::get('/forms/sliders', [Sliders::class, 'index'])->name('forms-sliders');
Route::get('/forms/switches', [Switches::class, 'index'])->name('forms-switches');
Route::get('/forms/extras', [Extras::class, 'index'])->name('forms-extras');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');
Route::get('/form/layouts-sticky', [StickyActions::class, 'index'])->name('form-layouts-sticky');

// form wizards
Route::get('/form/wizard-numbered', [FormWizardNumbered::class, 'index'])->name('form-wizard-numbered');
Route::get('/form/wizard-icons', [FormWizardIcons::class, 'index'])->name('form-wizard-icons');
Route::get('/form/validation', [Validation::class, 'index'])->name('form-validation');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
Route::get('/tables/datatables-basic', [DatatableBasic::class, 'index'])->name('tables-datatables-basic');
Route::get('/tables/datatables-advanced', [DatatableAdvanced::class, 'index'])->name('tables-datatables-advanced');
Route::get('/tables/datatables-extensions', [DatatableExtensions::class, 'index'])->name('tables-datatables-extensions');

// charts
Route::get('/charts/apex', [ApexCharts::class, 'index'])->name('charts-apex');
Route::get('/charts/chartjs', [ChartJs::class, 'index'])->name('charts-chartjs');

// maps
Route::get('/maps/leaflet', [Leaflet::class, 'index'])->name('maps-leaflet');

// laravel example
Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('laravel-example-user-management');
Route::resource('/user-list', UserManagement::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('content.dashboard.dashboards-analytics');
    })->name('dashboard');
});


//Solicitud de Cliente
Route::get('/solicitud-cliente', [solicitudClienteController::class, 'index'])->name('solicitud-cliente');
Route::post('/solicitud-cliente-registrar', [solicitudClienteController::class, 'registrar'])->name('solicitud-cliente-registrar');


//Vista formulario registro exitoso
Route::get('/Registro_exitoso', [solicitudClienteController::class, 'RegistroExitoso'])->name('Registro_exitoso');

//Enviar Correo
Route::get('/enviar-correo', [EnviarCorreoController::class, 'enviarCorreo']);

//Solicitud PDFs
Route::get('/carta_asignacion', [CartaAsignacionController::class, 'index'])->name('carta_asignacion');
Route::get('/solicitudinfo_cliente/{id}', [clientesProspectoController::class, 'info'])->name('solicitud_cliente');
Route::get('/asignacion_usuario', [CartaAsignacionController::class, 'access_user'])->name('asignacion_usuario');

Route::get('/prestacion_servicio_fisica/{id}', [clientesConfirmadosController::class, 'pdfServicioPersonaFisica070'])->name('prestacion_servicio_fisica');
Route::get('/prestacion_servicio_moral/{id}', [clientesConfirmadosController::class, 'pdfServicioPersonaMoral070'])->name('prestacion_servicio_moral');
Route::get('/Contrato_NMX-052', [CartaAsignacionController::class, 'CONTRATO_NMX_052'])->name('Contrato_NMX-052');
Route::get('/Contrato_prestacion_servicio_NOM-199', [CartaAsignacionController::class, 'Contrato_prestacion_servicio_NOM_199'])->name('Contrato_prestacion_servicio_NOM-199');
Route::get('/solicitud_Info_ClienteNOM-199', [CartaAsignacionController::class, 'solicitudInfoNOM_199'])->name('solicitud_Info_ClienteNOM-199');
Route::get('/inspeccion_geo_referenciacion', [CartaAsignacionController::class, 'InspeccionGeoReferenciacion'])->name('inspeccion_geo_referenciacion');
Route::get('/dictamen_cumplimiento_mezcal_granel', [CartaAsignacionController::class, 'dictamenDeCumplimientoGranel'])->name('dictamen-cumplimiento-granel');
Route::get('/bitacora_revision_SCFI2016', [CartaAsignacionController::class, 'bitacora_revision_SCFI2016'])->name('bitacora_revision_SCFI2016');
Route::get('/plan_de_auditoria', [CartaAsignacionController::class, 'PlanDeAuditoria'])->name('PlanDeAuditoria');
Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);
Route::get('/certificado_de_conformidad', [CartaAsignacionController::class, 'CertificadoConformidad199'])->name('CertificadoConformidad199');
Route::get('/certificado_como_productor', [CartaAsignacionController::class, 'CertificadoComoProductor'])->name('CertificadoComoProductor');
Route::get('/certificado_como_comercializador', [CartaAsignacionController::class, 'CertificadoComoComercializador'])->name('CertificadoComoComercializador');
Route::get('/certificado_como_envasador', [CartaAsignacionController::class, 'CertificadoComoEnvasador'])->name('CertificadoComoEnvasador');
Route::get('/solicitud_de_servicios', [CartaAsignacionController::class, 'SolicitudDeServicios052'])->name('CertificadoComoEnvasador');
Route::get('/dictamen_cumplimiento_instalaciones', [CartaAsignacionController::class, 'DictamenDeCumplimienoInstalaciones'])->name('DictamenDeCumplimienoInstalaciones');
Route::get('/carta_asignacion', [CartaAsignacionController::class, 'Contancia_trabajo'])->name('Contancia_trabajo');
Route::get('/informe_inspeccion_etiqueta', [CartaAsignacionController::class, 'InformeInspeccionEtiqueta'])->name('InformeInspeccionEtiqueta');



/* orden-trabajo-inspeccion-etiquetas */
Route::get('/orden_trabajo_inspeccion_etiquetas', [CartaAsignacionController::class, 'OrdenTrabajoInspeccionEtiquetas'])->name('OrdenTrabajoInspeccionEtiquetas');
/* lista_verificacion_nom051-mod20200327_solrev005 */
Route::get('/lista_verificacion_nom051-mod20200327_solrev005', [CartaAsignacionController::class, 'ListaVerificacionNom051Mod20200327Solrev005'])->name('ListaVerificacionNom051Mod20200327Solrev005');





//Etiquetas Etiqueta_Barrica
Route::get('/Etiqueta-2401ESPTOB', [CartaAsignacionController::class, 'Etiqueta'])->name('Etiqueta-2401ESPTOB');
Route::get('/Etiqueta-Muestra', [CartaAsignacionController::class, 'Etiqueta_muestra'])->name('Etiqueta-Muestra');
Route::get('/Etiqueta-Barrica', [CartaAsignacionController::class, 'Etiqueta_Barrica'])->name('Etiqueta-Barrica');

Route::get('/certificado_de_exportacion', [CartaAsignacionController::class, 'certificadoDeExportacion'])->name('certificadoExportacion');/*  */

//Certificados de instalaciones
Route::get('/certificado_comercializador', [CartaAsignacionController::class, 'certificadocom'])->name('certificado_comercializador');
Route::get('/certificado_envasador_mezcal', [CartaAsignacionController::class, 'certificadoenv'])->name('certificado_envasador_mezcal');
Route::get('/certificado_productor_mezcal', [CartaAsignacionController::class, 'certificadoprod'])->name('certificado_productor_mezcal');

//Clientes prospecto y confirmado
Route::get('/clientes/prospecto', [clientesProspectoController::class, 'UserManagement'])->name('clientes-prospecto');
Route::resource('/empresas-list', clientesProspectoController::class);
Route::get('/clientes-list/{id}/edit', [clientesProspectoController::class, 'edit']);
Route::post('/clientes/{id}/update', [clientesProspectoController::class, 'update'])->name('clientes.update');
Route::get('/solicitudInfoClienteNOM-199/{id}', [clientesProspectoController::class, 'pdfNOM199']);

Route::post('/aceptar-cliente', [clientesProspectoController::class, 'aceptarCliente']);
Route::get('/lista_empresas/{id}', [getFuncionesController::class, 'find_clientes_prospecto']);
Route::get('/lista_inspetores', [getFuncionesController::class, 'usuariosInspectores']);

/*obtener el editar*/
Route::get('/cliente_confirmado/{id}/edit', [clientesConfirmadosController::class, 'editarCliente'])->name('editarCliente');
/*editar*/
Route::put('/cliente_confirmado/{id}', [clientesConfirmadosController::class, 'update_cliente'])->name('editarCliente');

Route::get('/clientes/confirmados', [clientesConfirmadosController::class, 'UserManagement'])->name('clientes-confirmados');
Route::resource('/clientes-list', clientesConfirmadosController::class);
Route::get('/carta_asignacion/{id}', [clientesConfirmadosController::class, 'pdfCartaAsignacion'])->name('carta_asignacion');
Route::get('/carta_asignacion052/{id}', [clientesConfirmadosController::class, 'pdfCartaAsignacion052'])->name('carta_asignacion052');

//Marcas y catalogo
Route::get('/catalogo/marcas', [marcasCatalogoController::class, 'UserManagement'])->name('catalogo-marcas');
Route::resource('/catalago-list', marcasCatalogoController::class);
Route::resource('marcas-list', marcasCatalogoController::class)->except(['create', 'edit']);
Route::get('/marcas-list/{id}/edit', [marcasCatalogoController::class, 'edit'])->name('marcas.edit');
Route::post('/marcas-list/{id}', [marcasCatalogoController::class, 'store']);
Route::post('/update-fecha-vigencia/{id_documento}', [marcasCatalogoController::class, 'updateFechaVigencia']);
Route::post('/marcas-list/update', [marcasCatalogoController::class, 'update'])->name('marcas.update');
Route::post('/marcas-list/update', [marcasCatalogoController::class, 'update'])->name('marcas.update');
Route::post('/etiquetado/updateEtiquetas', [marcasCatalogoController::class, 'updateEtiquetas']);
Route::get('/marcas-list/{id}/editEtiquetas', [marcasCatalogoController::class, 'editEtiquetas'])->name('marcas.edit');



/* ruta de clases catalogo */
Route::get('/catalogo/clases', [ClaseController::class, 'UserManagement'])->name('catalogo-clases');
Route::get('/clases-list', [ClaseController::class, 'index']);
Route::delete('/clases-list/{id_clase}', [ClaseController::class, 'destroy'])->name('clases.destroy');
Route::post('/catalogo', [ClaseController::class, 'store'])->name('catalogo.store');
Route::get('/clases-list/{id_clase}/edit', [ClaseController::class, 'edit'])->name('clases.edit');
Route::put('/clases-list/{id_clase}', [ClaseController::class, 'update'])->name('clases.update');

//Categorias Agave
Route::get('/catalogo/categorias', [categoriasController::class, 'UserManagement'])->name('catalogo-categorias');
Route::resource('/categorias-list', categoriasController::class);
Route::delete('categorias/{id_categoria}', [categoriasController::class, 'destroy'])->name('categorias.destroy');
Route::post('/categorias', [categoriasController::class, 'store'])->name('categorias.store');
Route::get('/categorias-list/{id_categoria}/edit', [categoriasController::class, 'edit'])->name('categoria.edit');
Route::put('/categorias-list/{id_categoria}', [categoriasController::class, 'update'])->name('categoria.update');

Route::get('/catalogo/lotes_granel', [LotesGranelController::class, 'UserManagement'])->name('catalogo-lotes-granel');
Route::resource('/lotes-granel-list', LotesGranelController::class);
Route::delete('/lotes-granel-list/{id_lote_granel}', [LotesGranelController::class, 'destroy']);
Route::post('/lotes-register/store', [LotesGranelController::class, 'store'])->name('lotes-register.store');
Route::get('/lotes-a-granel/{id_lote_granel}/edit', [LotesGranelController::class, 'edit'])->name('lotes-a-granel.edit');
Route::post('/lotes-a-granel/{id_lote_granel}', [LotesGranelController::class, 'update']);

//Lotes de envasado
Route::get('/catalogo/lotes', [LotesEnvasadoController::class, 'UserManagement'])->name('catalogo-lotes');
Route::resource('/lotes-list', LotesEnvasadoController::class);
Route::post('/lotes-envasado', [LotesEnvasadoController::class, 'store']);
Route::get('/lotes-envasado/edit/{id}', [lotesEnvasadoController::class, 'edit']);
Route::post('/lotes-envasado/update/', [lotesEnvasadoController::class, 'update']);
Route::get('/lotes-envasado/editSKU/{id}', [lotesEnvasadoController::class, 'editSKU']);
Route::post('/lotes-envasado/updateSKU/', [lotesEnvasadoController::class, 'updateSKU']);
 


//Domicilios fiscal
Route::get('/domicilios/fiscal', [ClaseController::class, 'UserManagement'])->name('domicilio_fiscal');

//Domicilios Instalaciones
Route::get('/domicilios/instalaciones', [DomiciliosController::class, 'UserManagement'])->name('domicilio-instalaciones');
Route::resource('/instalaciones-list', DomiciliosController::class);
Route::delete('instalaciones/{id_instalacion}', [DomiciliosController::class, 'destroy']);
Route::post('/instalaciones', [DomiciliosController::class, 'store']);
Route::get('domicilios/edit/{id_instalacion}', [DomiciliosController::class, 'edit'])->name('domicilios.edit');
Route::put('instalaciones/{id_instalacion}', [DomiciliosController::class, 'update']);

//Domicilio predios
Route::get('/domicilios/predios', [PrediosController::class, 'UserManagement'])->name('domicilios-predios');
Route::resource('/predios-list', PrediosController::class);
Route::delete('/predios-list/{id_predio}', [PrediosController::class, 'destroy'])->name('predios-list.destroy');
Route::post('/predios-register/store', [PrediosController::class, 'store'])->name('predios-register.store');
Route::get('/domicilios-predios/{id_predio}/edit', [PrediosController::class, 'edit'])->name('domicilios-predios.edit');
Route::post('/domicilios-predios/{id_predio}', [PrediosController::class, 'update'])->name('domicilios-predios.update');
Route::post('/domicilios-predios/{id_predio}/inspeccion', [PrediosController::class, 'inspeccion'])->name('domicilios-predios.inspeccion');
Route::get('/pre-registro_predios/{id_predio}', [prediosController::class, 'PdfPreRegistroPredios'])->name('pre-registro_predios');
Route::get('/inspeccion_geo_referenciacion/{id_predio}', [prediosController::class, 'PDFInspeccionGeoReferenciacion'])->name('inspeccion_geo_referenciacion');
Route::get('/Registro_de_Predios_Maguey_Agave/{id_predio}', [prediosController::class, 'PDFRegistroPredios'])->name('PDF_Registro_Predios');
Route::post('/registro-Predio/{id_predio}', [PrediosController::class, 'registroPredio'])->name('registro-predios.registroPredio');
Route::get('/solicitudServicio/{id_predio}', [PrediosController::class, 'pdf_solicitud_servicios_070']);

//Domicilio Destinos
Route::get('/domicilios/destinos', [DestinosController::class, 'UserManagement'])->name('domicilio-destinos');
Route::resource('/destinos-list', DestinosController::class);
Route::delete('/destinos-list/{id_direccion}', [DestinosController::class, 'destroy'])->name('destinos-list.destroy');
Route::post('/destinos-register/{id_direccion}', [DestinosController::class, 'store'])->name('destinos-register.store');
/* route::get('/destinos-list/{id_direccion}/edit', [DestinoController::class, 'edit'])->name('destinos.edit');
 */route::post('/destinos-update/{id_direccion}', [DestinosController::class, 'update'])->name('destinos.update');

//Usuarios
Route::get('/usuarios/clientes', [UsuariosController::class, 'UserManagement'])->name('usuarios-clientes');
Route::resource('/user-list', UsuariosController::class);
Route::get('/pdf_asignacion_usuario/{id}', [UsuariosController::class, 'pdfAsignacionUsuario'])->name('pdf_asignacion_usuario');

Route::get('/usuarios/inspectores', [UsuariosInspectoresController::class, 'inspectores'])->name('usuarios-inspectores');
Route::resource('/inspectores-list', UsuariosInspectoresController::class);

Route::get('/usuarios/personal', [UsuariosPersonalController::class, 'personal'])->name('usuarios-personal');
Route::resource('/personal-list2', UsuariosPersonalController::class);

//Consejo usuarios
Route::get('/usuarios/consejo', [UsuariosConsejoController::class, 'consejo'])->name('usuarios-consejo');
Route::resource('/consejo-list', UsuariosConsejoController::class);

//Documentacion
Route::get('/documentacion', [documentacionController::class, 'index'])->name('documentacion');
Route::get('/documentacion/getNormas', [documentacionController::class, 'getNormas'])->name('documentacion.getNormas');
Route::get('documentacion/getActividades', [documentacionController::class, 'getActividades'])->name('documentacion.getActividades');
Route::post('/upload', [documentacionController::class, 'upload'])->name('upload');

/*-------------------Tipos de maguey/agave-------------------*/
/*mostrar*/
Route::get('/catalogo/tipos', [tiposController::class, 'UserManagement'])->name('catalogo-tipos');
Route::resource('/tipos-list', tiposController::class);
/*eliminar*/
Route::delete('/tipos-list/{id_tipo}', [tiposController::class, 'destroy'])->name('tipos.destroy');
/*registrar*/
Route::post('/tipos-list', [tiposController::class, 'store'])->name('tipo.store');
/*obtener el editar*/
Route::get('/edit-list/{id_tipo}/edit', [tiposController::class, 'edit'])->name('tipos.edit');
/*editar*/
Route::put('/edit-list/{id_tipo}', [tiposController::class, 'update'])->name('tipos.update');

Route::get('/getDatos/{empresa}', [getFuncionesController::class, 'getDatos'])->name('getDatos');

//Guias de agave o maguey
Route::get('/guias/guias_de_agave', [GuiasController::class, 'UserManagement'])->name('traslado-guias');
Route::resource('/guias-list', GuiasController::class);
Route::post('/guias/store', [GuiasController::class, 'store']);
Route::get('/guia_de_translado/{id_guia}', [GuiasController::class, 'guiasTranslado'])->name('Guias_Translado');
Route::get('/edit/{id_guia}', [GuiasController::class, 'edit'])->name('guias.edit');
Route::post('/update', [GuiasController::class, 'update'])->name('guias.update');
Route::get('/editGuias/{run_folio}', [GuiasController::class, 'editGuias']);

//Route::get('/guias/getPlantaciones/{id_predio}', [GuiasController::class, 'getPlantacionesByPredio']);

/*-------------------Dictamenes de instalaciones-------------------*/
/*mostrar*/
Route::get('dictamenes/instalaciones', [InstalacionesController::class, 'UserManagement'])->name('dictamenes-instalaciones');
Route::resource('insta', InstalacionesController::class);
/*eliminar*/
Route::delete('insta/{id_dictamen}', [InstalacionesController::class, 'destroy'])->name('instalacion.delete');
/*registrar*/
Route::post('insta', [InstalacionesController::class, 'store'])->name('instalacion.store');
/*obtener el editar*/
Route::get('insta/{id_dictamen}/edit', [InstalacionesController::class, 'edit'])->name('instalacion.edit');
/*editar*/
Route::put('insta/{id_dictamen}', [InstalacionesController::class, 'update'])->name('tipos.update');

//Pdfs de dictamen de instalaciones
Route::get('/dictamen_productor/{id_dictamen}', [InstalacionesController::class, 'dictamen_productor'])->name('dictamen_productor');
Route::get('/dictamen_envasador/{id_dictamen}', [InstalacionesController::class, 'dictamen_envasador'])->name('dictamen_envasador');
Route::get('/dictamen_comercializador/{id_dictamen}', [InstalacionesController::class, 'dictamen_comercializador'])->name('dictamen_comercializador');
Route::get('/dictamen_almacen/{id_dictamen}', [InstalacionesController::class, 'dictamen_almacen'])->name('dictamen_almacen');
Route::get('/dictamen_maduracion/{id_dictamen}', [InstalacionesController::class, 'dictamen_maduracion'])->name('dictamen_maduracion');

/*------------------- Dictamenes a granel -------------------*/
Route::get('/dictamenes/productos', [DictamenGranelController::class, 'UserManagement'])->name('dictamenes-productos');
Route::resource('/dictamen-granel-list', DictamenGranelController::class);
Route::delete('dictamen/granel/{id_dictamen}', [DictamenGranelController::class, 'destroy'])->name('dictamen.delete');
Route::post('dictamenes-granel',[DictamenGranelController::class, 'store'])->name('dictamen.store');
route::get('/dictamenes/productos/{id_dictamen}/edit', [DictamenGranelController::class, 'edit'])->name('dictamenes.edit');
Route::post('/dictamenes/productos/{id_dictamen}/update', [DictamenGranelController::class, 'update'])->name('dictamen.update');
Route::get('/dictamenes/productos/{id_dictamen}/foliofq', [DictamenGranelController::class, 'foliofq'])->name('dictamenes.foliofq');
Route::post('/dictamenes/productos/{id_dictamen}/reexpedir', [DictamenGranelController::class, 'reexpedirDictamen'])->name('dictamenes.reexpedir');

/*------------------- PDFS de Dictamenes a granel -------------------*/
// Ruta para el PDF con ID
route::get('/dictamen_cumplimiento_mezcal_granel/{id_dictamen}', [DictamenGranelController::class, 'dictamenDeCumplimientoGranel'])->name('dictamen-cumplimiento-granel');


/*------------------- Dictamenes envadaso -------------------*/
Route::get('/dictamenes/envasado', [DictamenEnvasadoController::class, 'UserManagement'])->name('dictamenes-envasado');
Route::resource('/dictamen-envasado-list', DictamenEnvasadoController::class);
Route::delete('dictamen/envasado/{id_dictamen}', [DictamenEnvasadoController::class, 'destroy'])->name('dictamen.delete');
Route::post('dictamenes-envasado',[DictamenEnvasadoController::class, 'store'])->name('dictamen.store');
route::get('/dictamenes/envasado/{id_dictamen}/edit', [DictamenEnvasadoController::class, 'edit'])->name('dictamenes.edit');
Route::post('/dictamenes/envasado/{id_dictamen}/update', [DictamenEnvasadoController::class, 'update'])->name('dictamen.update');
Route::post('/dictamenes/envasado/{id_dictamen}/reexpedir', [DictamenEnvasadoController::class, 'reexpedirDictamen'])->name('dictamenes.reexpedir');

/*------------------- PDFS de Dictamenes envadaso -------------------*/
// Ruta para el PDF con ID
route::get('/Dictamen-MezcalEnvasado/{id_dictamen}', [DictamenEnvasadoController::class, 'dictamenDeCumplimientoEnvasado'])->name('dictamen-cumplimiento-envasado');


//Documentacion
Route::get('/documentos', [DocumentosController::class, 'UserManagement'])->name('catalogo-documentos');
Route::resource('/documentos-list', DocumentosController::class);
Route::delete('/documentos/{id}', [DocumentosController::class, 'destroy'])->name('documentos.destroy');
Route::post('/documentos', [DocumentosController::class, 'store']);

// Ruta para obtener los datos del documento para editar
Route::get('/documentos/{id}/edit', [DocumentosController::class, 'edit']);

// Ruta para actualizar el documento
Route::put('/documentos/{id}', [DocumentosController::class, 'update']);



//Inspecciones
Route::get('/inspecciones', [inspeccionesController::class, 'UserManagement'])->name('inspecciones');
Route::resource('inspecciones-list', inspeccionesController::class);
Route::post('/asignar-inspector', [inspeccionesController::class, 'asignarInspector']);
Route::get('/oficio_de_comision/{id_inspeccion}', [inspeccionesController::class, 'pdf_oficio_comision'])->name('oficioDeComision');
Route::get('/orden_de_servicio/{id_inspeccion}', [inspeccionesController::class, 'pdf_orden_servicio'])->name('ordenDeServicio');
Route::post('/agregar-resultados', [inspeccionesController::class, 'agregarResultados']);
//update acta
Route::get('/acta-solicitud/edit/{id_acta}', [inspeccionesController::class, 'editActa']);

//pdf rutas
Route::post('/acta-unidades', [inspeccionesController::class, 'store'])->name('acta.unidades.store');
Route::get('/acta_circunstanciada_unidades_produccion/{id_inspeccion}', [inspeccionesController::class, 'acta_circunstanciada_produccion'])->name('acta_circunstanciada_unidades_produccion');


//Hologramas - solicitud hologramas
Route::get('/hologramas/solicitud', [solicitudHolograma::class, 'UserManagement'])->name('hologramas-solicitud');
Route::resource('/hologramas-list', solicitudHolograma::class);
Route::post('/hologramas/store', [solicitudHolograma::class, 'store']);
Route::get('/solicitud_holograma/edit/{id_solicitud}', [solicitudHolograma::class, 'edit']);
Route::post('/solicitud_holograma/update/', [solicitudHolograma::class, 'update']);
Route::get('/solicitud_de_holograma/{id}', [solicitudHolograma::class, 'ModelsSolicitudHolograma'])->name('solicitudDeHologramas');
Route::post('/solicitud_holograma/update2', [solicitudHolograma::class, 'update2']);
Route::post('/solicitud_holograma/update3', [solicitudHolograma::class, 'update3']);
Route::post('/solicitud_holograma/updateAsignar', [solicitudHolograma::class, 'updateAsignar']);
Route::post('/solicitud_holograma/updateRecepcion', [solicitudHolograma::class, 'updateRecepcion']);
Route::post('/solicitud_holograma/storeActivar', [solicitudHolograma::class, 'storeActivar']);
Route::get('/solicitud_holograma/editActivos/{id}', [solicitudHolograma::class, 'editActivos']);
Route::get('/solicitud_holograma/editActivados/{id}', [solicitudHolograma::class, 'editActivados']);




//Certificados Instalaciones
Route::get('certificados/instalaciones', [Certificado_InstalacionesController::class, 'UserManagement'])->name('certificados-instalaciones');
Route::resource('certificados-list',Certificado_InstalacionesController::class);
Route::post('certificados-list', [Certificado_InstalacionesController::class, 'store'])->name('certificados.store');
Route::get('certificados-list/{id}/edit', [Certificado_InstalacionesController::class, 'edit']);
Route::put('certificados-list/{id}', [Certificado_InstalacionesController::class, 'update']);
Route::get('/ruta-para-obtener-revisores', [Certificado_InstalacionesController::class, 'obtenerRevisores']);
Route::post('/asignar-revisor', [Certificado_InstalacionesController::class, 'storeRevisor'])->name('asignarRevisor'); //Agregar
Route::post('/certificados/reexpedir', [Certificado_InstalacionesController::class, 'reexpedir'])->name('certificados.reexpedir');

//Pdfs de certificados de instalaciones
Route::get('/certificado_comercializador/{id_certificado}', [Certificado_InstalacionesController::class, 'pdf_certificado_comercializador'])->name('certificado_comercializador');
Route::get('/certificado_envasador_mezcal/{id_certificado}', [Certificado_InstalacionesController::class, 'pdf_certificado_envasador'])->name('certificado_envasador_mezcal');
Route::get('/certificado_productor_mezcal/{id_certificado}', [Certificado_InstalacionesController::class, 'pdf_certificado_productor'])->name('certificado_productor_mezcal');



//solicitud hologrammas
Route::post('/hologramas/store', [solicitudHolograma::class, 'store']);
Route::get('/solicitud_holograma/edit/{id_solicitud}', [solicitudHolograma::class, 'edit']);
Route::post('/solicitud_holograma/update/', [solicitudHolograma::class, 'update']);
Route::get('/solicitud_de_holograma/{id}', [solicitudHolograma::class, 'ModelsSolicitudHolograma'])->name('solicitudDeHologramas');
Route::post('/solicitud_holograma/update2', [solicitudHolograma::class, 'update2']);
Route::post('/solicitud_holograma/update3', [solicitudHolograma::class, 'update3']);
Route::post('/solicitud_holograma/updateAsignar', [solicitudHolograma::class, 'updateAsignar']);
Route::post('/solicitud_holograma/updateRecepcion', [solicitudHolograma::class, 'updateRecepcion']);
Route::post('/verificar-folios', [solicitudHolograma::class, 'verificarFolios']);
Route::post('/solicitud_holograma/update/updateActivar', [solicitudHolograma::class, 'updateActivar']);


//Módulo de solicitudes
Route::get('/solicitudes-historial', [solicitudesController::class, 'UserManagement'])->name('solicitudes-historial');
Route::resource('/solicitudes-list', solicitudesController::class);
Route::get('/solicitud_de_servicio/{id_solicitud}', [solicitudesController::class, 'pdf_solicitud_servicios_070'])->name('solicitudservi');
Route::post('/registrar-solicitud-georeferenciacion', [solicitudesController::class, 'registrarSolicitudGeoreferenciacion'])->name('registrarSolicitudGeoreferenciacion');
Route::post('/registrar-solicitud-muestreo-agave', [solicitudesController::class, 'registrarSolicitudMuestreoAgave'])->name('registrarSolicitudMuestreoAgave');
Route::get('/verificar-solicitud', [solicitudesController::class, 'verificarSolicitud'])->name('verificarSolicitud');


/* Route::get('/dictamenes', [DictamenesController::class, 'getDictamenes'])->name('dictamenes.list');
 */
//catalago equipos
Route::get('/catalogo/equipos', [catalogoEquiposController::class, 'UserManagement'])->name('catalogo-equipos');
Route::resource('/equipos-list', catalogoEquiposController::class);
Route::post('/equipos/store', [catalogoEquiposController::class, 'store'])->name('equipos.store');
Route::get('/equipos-list/{id_equipo}/edit', [catalogoEquiposController::class, 'edit'])->name('equipos.edit');
Route::post('/equipos-list/update', [catalogoEquiposController::class, 'update'])->name('equipos.update');

//Tipo
Route::get('/solicitudes', [SolicitudesTipoController::class, 'UserManagement'])->name('solicitudes-tipo');
Route::get('solicitudes/tipos', [SolicitudesTipoController::class, 'getSolicitudesTipos'])->name('obtener.solicitudes.tipos');

//Notificaciones
Route::post('/notificacion-leida/{id}', [NotificacionController::class, 'marcarNotificacionLeida'])->name('notificacion.leida');

//Trazabilidad
Route::get('/trazabilidad/{id}', [TrazabilidadController::class, 'mostrarLogs'])->name('mostrarLogs');

Route::get('/Plan-auditoria-esquema', [CartaAsignacionController::class, 'PlanAuditoria'])->name('Plan-auditoria-esquema');
Route::get('/Reporte-Tecnico', [CartaAsignacionController::class, 'ReporteTecnico'])->name('Reporte-Tecnico');

//
Route::get('/Pre-certificado', [CartaAsignacionController::class, 'PreCertificado'])->name('Pre-certificado');
Route::get('/Dictamen-MezcalEnvasado', [CartaAsignacionController::class, 'DictamenMezcalEnvasado'])->name('Dictamen-MezcalEnvasado');
Route::get('/Plan-auditoria-esquema', [CartaAsignacionController::class, 'PlanAuditoria'])->name('Plan-auditoria-esquema');
Route::get('/Reporte-Tecnico', [CartaAsignacionController::class, 'ReporteTecnico'])->name('Reporte-Tecnico');


//PDFS NEW
Route::get('/Solicitud-Especificaciones', [CartaAsignacionController::class, 'SolicitudEspecificaciones'])->name('Solicitud-Especificaciones');
Route::get('/Oreden-Trabajo', [CartaAsignacionController::class, 'OrdenTrabajo'])->name('Oreden-Trabajo');
Route::get('/Solicitud-Servicio-UNIIC', [CartaAsignacionController::class, 'SolicitudUNIIC'])->name('Solicitud-Servicio-UNIIC');

/* Route::get('/lista_empresas/{id_empresa}', [clientesConfirmadosController::class, 'obtenerContratos']);
 */
Route::get('/empresa_contrato/{id_empresa}', [clientesConfirmadosController::class, 'obtenerContratosPorEmpresa']);
Route::get('/empresa_num_cliente/{id_empresa}', [clientesConfirmadosController::class, 'obtenerNumeroCliente']);
Route::post('/actualizar-registros', [clientesConfirmadosController::class, 'actualizarRegistros']);
Route::post('/registrar-clientes', [ClientesConfirmadosController::class, 'registrarClientes'])->name('clientes.registrar');


//Revision Personal
Route::get('/revision/personal', [RevisionPersonalController::class, 'UserManagement'])->name('revision-personal');
Route::resource('/personal-list', RevisionPersonalController::class);
Route::post('/revisor/registrar-respuestas', [RevisionPersonalController::class, 'registrarRespuestas'])->name('registrar.respuestas');
Route::get('/revisor/obtener-respuestas/{id_revision}', [RevisionPersonalController::class, 'obtenerRespuestas']);
Route::get('/get-certificado-url/{id_revision}/{tipo}', [RevisionPersonalController::class, 'getCertificadoUrl']);
Route::get('/bitacora_revicionPersonalOCCIDAM/{id}', [RevisionPersonalController::class, 'bitacora_revicionPersonalOCCIDAM']); //New
Route::post('/registrar-aprobacion', [RevisionPersonalController::class, 'registrarAprobacion'])->name('registrar.aprobacion');
Route::get('/aprobacion/{id}', [RevisionPersonalController::class, 'cargarAprobacion']);
Route::get('/obtener/historial/{id_revision}', [RevisionPersonalController::class, 'cargarHistorial']);
