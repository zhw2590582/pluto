jQuery(document).ready(function($) {
	
	/*	判断密钥验证 */		
	$verify=$(".regular-text").val();
	if($verify==""){
		$(".verify_state").addClass("verify_no");
		$(".verify_state").removeClass("verify_yes");
		$(".verify_info").html("<b style='color:red;'>未验证</b>");
	}else{
		$(".verify_state").addClass("verify_yes");
		$(".verify_state").removeClass("verify_no");
		$(".verify_info").html("<b style='color:#05991D;'>验证成功</b>");
	}
	
	/*	判断文章形式 */
	$(':radio[name="post_format"]').change(function() {
		$('#standard_options').toggle(this.value == 0);
		$('#status_options').toggle(this.value == 'status');
		$('#aside_options').toggle(this.value == 'aside');
	});
	$(':radio[name="post_format"]:checked').change();
	
	/*	判断页面模板 */	
    $('#page_template').change( function() {

      $('#default_page').hide();
      $('#about_page').hide();
      $('#archive_page').hide();
      $('#work_page').hide();
      $('#friend_page').hide();
      $('#message_page').hide();

      switch( $( this ).val() ) {

        case 'custom-about.php':
          $('#about_page').show();
        break;

        case 'custom-archive.php':
          $('#archive_page').show();
        break;

        case 'custom-work.php':
          $('#work_page').show();
        break;              
              
        case 'custom-friend.php':
        $('#friend_page').show();
        break;		
		
        case 'custom-message.php':
          $('#message_page').show();
        break;					
		
        default:
          $('#default_page').show();
        break;
      }

    }).change();

});