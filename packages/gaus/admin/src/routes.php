<?php

Route::any('admin', ['as' => 'admin', 'uses' => 'Gaus\Admin\Controllers\AdminController@main']);

Route::controller('admin/news', 'Gaus\Admin\Controllers\AdminNewsController', [
	'getIndex' => 'admin.news',
	'getEdit' => 'admin.news.edit',
	'postSave' => 'admin.news.save',
	'postDelete' => 'admin.news.del',
]);

Route::controller('admin/reviews', 'Gaus\Admin\Controllers\AdminReviewsController', [
	'getIndex' => 'admin.reviews',
	'getEdit' => 'admin.reviews.edit',
	'postSave' => 'admin.reviews.save',
	'postReorder' => 'admin.reviews.reorder',
	'postDelete' => 'admin.reviews.del',
]);

Route::controller('admin/settings', 'Gaus\Admin\Controllers\AdminSettingsController', [
	'getIndex' => 'admin.settings',
	'getGroupItems' => 'admin.settings.groupItems',
	'postGroupSave' => 'admin.settings.groupSave',
	'postGroupDelete' => 'admin.settings.groupDel',
	'postClearValue' => 'admin.settings.clearValue',
	'anyEditSetting' => 'admin.settings.edit',
	'anyBlockParams' => 'admin.settings.blockParams',
	'postEditSettingSave' => 'admin.settings.editSave',
	'postSave' => 'admin.settings.save',
	'anyBlockParams' => 'admin.settings.blockParams',
]);

Route::controller('admin/users', 'Gaus\Admin\Controllers\AdminUsersController', [
	'getIndex' => 'admin.users',
	'postEdit' => 'admin.users.edit',
	'postSave' => 'admin.users.save',
	'postDelete' => 'admin.users.del',
]);

Route::controller('admin/pages', 'Gaus\Admin\Controllers\AdminPagesController', [
	'getIndex' => 'admin.pages',
	'postEdit' => 'admin.pages.edit',
	'postSave' => 'admin.pages.save',
	'postReorder' => 'admin.pages.reorder',
	'postDelete' => 'admin.pages.del',
]);

Route::controller('admin/catalog', 'Gaus\Admin\Controllers\AdminCatalogController', [
	'getIndex' => 'admin.catalog',
	'postProducts' => 'admin.catalog.products',
	'postCatalogEdit' => 'admin.catalog.catalogEdit',
	'postCatalogSave' => 'admin.catalog.catalogSave',
	'postCatalogReorder' => 'admin.catalog.catalogReorder',
	'postCatalogDelete' => 'admin.catalog.catalogDel',
	'postProductEdit' => 'admin.catalog.productEdit',
	'postProductSave' => 'admin.catalog.productSave',
	'postProductReorder' => 'admin.catalog.productReorder',
	'postProductDelete' => 'admin.catalog.productDel',
	'postProductImageUpload' => 'admin.catalog.productImageUpload',
	'postProductImageDelete' => 'admin.catalog.productImageDel',
]);

Route::controller('admin/gallery', 'Gaus\Admin\Controllers\AdminGalleryController', [
	'anyIndex' => 'admin.gallery',
	'postGallerySave' => 'admin.gallery.gallerySave',
	'postGalleryDelete' => 'admin.gallery.galleryDel',
	'anyItems' => 'admin.gallery.items',
	'postImageUpload' => 'admin.gallery.imageUpload',
	'postImageEdit' => 'admin.gallery.imageEdit',
	'postImageDataSave' => 'admin.gallery.imageDataSave',
	'postImageDelete' => 'admin.gallery.imageDel',
]);

Route::controller('admin/feedbacks', 'Gaus\Admin\Controllers\AdminFeedbacksController', [
	'getIndex' => 'admin.feedbacks',
	'postRead' => 'admin.feedbacks.read',
	'postDelete' => 'admin.feedbacks.del',
]);