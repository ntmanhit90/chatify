<?php
/**
 * -----------------------------------------------------------------
 * NOTE : There is two routes has a name (user & group),
 * any change in these two route's name may cause an issue
 * if not modified in all places that used in (e.g Chatify class,
 * Controllers, chatify javascript file...).
 * -----------------------------------------------------------------
 */

use Illuminate\Support\Facades\Route;

/*
* This is the main app route [Chatify Messenger]
*/
Route::get('/', 'MessagesController@index')->name(config('chatify.routes.prefix'));

/**
 *  Fetch info for specific id [user/group]
 */
Route::post('/idInfo', 'MessagesController@idFetchData');

/**
 * Send message route
 */
Route::post('/sendMessage', 'MessagesController@send')->name('send.message');

/**
 * Fetch messages
 */
Route::post('/fetchMessages', 'MessagesController@fetch')->name('fetch.messages');

/**
 * Download attachments route to create a downloadable links
 */
Route::get('/download/{fileName}', 'MessagesController@download')->name(config('chatify.attachments.download_route_name'));

/**
 * Authentication for pusher private channels
 */
Route::post('/chat/auth', 'MessagesController@pusherAuth')->name('pusher.auth');

/**
 * Make messages as seen
 */
Route::post('/makeSeen', 'MessagesController@seen')->name('messages.seen');

/**
 * Get contacts
 */
Route::get('/getContacts', 'MessagesController@getContacts')->name('contacts.get');

/**
 * Update contact item data
 */
Route::post('/updateContacts', 'MessagesController@updateContactItem')->name('contacts.update');


/**
 * Star in favorite list
 */
Route::post('/star', 'MessagesController@favorite')->name('star');

/**
 * get favorites list
 */
Route::post('/favorites', 'MessagesController@getFavorites')->name('favorites');

/**
 * Get shared photos
 */
Route::post('/shared', 'MessagesController@sharedFiles')->name('shared');

/**
 * Delete Conversation
 */
Route::post('/deleteConversation', 'MessagesController@deleteConversation')->name('conversation.delete');

/**
 * Delete Message
 */
Route::post('/deleteMessage', 'MessagesController@deleteMessage')->name('message.delete');

/**
 * Update setting
 */
Route::post('/updateSettings', 'MessagesController@updateSettings')->name('avatar.update');

/**
 * Set active status
 */
Route::post('/setActiveStatus', 'MessagesController@setActiveStatus')->name('activeStatus.set');


/*
* [GroupCHAT]
*/
Route::get('/conversation', 'ConversationController@index')->name('conv.index');
Route::get('/conversation/info/{conversation}', 'ConversationController@detail')->name('conv.detail');
Route::get('/conversation/card/{conversation}', 'ConversationController@card')->name('conv.card');
Route::post('/conversation', 'ConversationController@store')->name('conv.create');
Route::post('/conversation/{conversation}', 'ConversationController@update')->name('conv.update');
Route::get('/conversation/{conversation}', 'ConversationController@view')->name('conv.view');
Route::post('/conversation/{conversation}/messages', 'MessagesController@fetch')->name('conv.messages');
/**
 * Search in messenger
 */
Route::get('/search', 'ConversationController@index')->name('search');
