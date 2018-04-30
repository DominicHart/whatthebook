$(document).on("click", ".btneditcard" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/edit_card.php', {js_submit_value : name});
    $("#editcard").css("display", "block");
});
$(document).on("click", ".btndeletecard" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/delete_card.php', {js_submit_value : name});
    $("#deletecard").css("display", "block");
});
$(document).on("click", ".btnedituser" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/edit_user.php', {js_submit_value : name});
    $("#edituser").css("display", "block");
});
$(document).on("click", ".btndeleteuser" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/delete_user.php', {js_submit_value : name});
    $("#deleteuser").css("display", "block");
});
$(document).on("click", ".btneditgenre" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/edit_genre.php', {js_submit_value : name});
    $("#editgenre").css("display", "block");
});
$(document).on("click", ".btndeletegenre" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/delete_genre.php', {js_submit_value : name});
    $("#deletegenre").css("display", "block");
});
$(document).on("click", ".btneditsubgenre" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/edit_subgenre.php', {js_submit_value : name});
    $("#editsubgenre").css("display", "block");
});
$(document).on("click", ".btndeletesubgenre" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/delete_subgenre.php', {js_submit_value : name});
    $("#deletesubgenre").css("display", "block");
});
$(document).on("click", ".btneditpublisher" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/edit_publisher.php', {js_submit_value : name});
    $("#editpublisher").css("display", "block");
});
$(document).on("click", ".btndeletepublisher" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/delete_publisher.php', {js_submit_value : name});
    $("#deletepublisher").css("display", "block");
});
$(document).on("click", ".btneditbook" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/edit_book.php', {js_submit_value : name});
    $("#editbook").css("display", "block");
});
$(document).on("click", ".btndeletebook" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/delete_book.php', {js_submit_value : name});
    $("#deletebook").css("display", "block");
});
$(document).on("click", ".btndeleteorder" , function(){
    var name = this.name;
    $("#edit-delete").load('parts/delete_order.php', {js_submit_value : name});
    $("#deleteorder").css("display", "block");
});