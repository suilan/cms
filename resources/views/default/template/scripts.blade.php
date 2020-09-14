<!-- Buttom in all pages -->
<script type="text/javascript">
	jQuery('.backtotop').click(function () {
		jQuery('body,html').animate({
				scrollTop:0
			}, 1200);
		return false;
	});
</script>
<!-- Login at the top of the pages -->
@if (count($errors) > 0)
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#myLogin").modal("show");
		});
	</script>
@endif
<!-- Menu at all pages-->
<script type="text/javascript">
	jQuery(document).ready(function($) {
		// Mask to the Consulta Editais e Titulo Page
		$("#documento").inputmask("999.999.999-99");
		$('#tipo-doc').change(function() {
			var value = this.value;
			if(value==1){
				$("#documento").inputmask("999.999.999-99");
			}
			else{
				$("#documento").inputmask("99.999.999/9999-99");
			}
		});

		$('.btn-navbar').click(function(){
				$(this).children().toggleClass('fa-times');
		});
		$("ul.resmenu li.haveChild").each(function() {
			$(this).children(".res-wrapnav").css('display', 'none');
			var ua = navigator.userAgent,
			event = (ua.match(/iPad/i)) ? "touchstart" : "click";
			$(this).children(".menuress-toggle").bind(event, function() {

				$(this).parent().addClass(function(){
					if($(this).hasClass("active")){
						//$(this).removeClass("active");
						return "";
					}
					return "active";
				});

				$(this).siblings(".res-wrapnav").slideDown(350);
				$(this).parent().siblings("li").children(".res-wrapnav").slideUp(350);
				$(this).parent().siblings("li").removeClass("active");
			});

		});
	});
</script>
<script id="form-contato">
	jQuery(document).ready(function($){
		(function(element){
			var $element=$(element);
			$('.ca-tooltip',$element).tooltip();
			var $form=$('#el_ctajax_form',$element);
			var $ajax_url='{{url('contato')}}';
			var $name=$('#cainput_name',$element);
			var $email=$('#cainput_email',$element);
			var $subject=$('#cainput_subject',$element);
			var $message=$('#cainput_message',$element);
			var $captcha=$('#cainput_captcha',$element);
			var $recaptcha=$('#dynamic_recaptcha_1',$element);
			var $newsletter=$('#cainput_newsletter',$element);
			var $token=$('#cainput_token',$element);
			var $ca_submit=$('#cainput_submit',$element);
			var $image_load=$('.el-ctajax-loadding',$element);
			var $notice_return=$('.el-ctajax-return',$element);
			var $return_error=$('.return-error',$element);
			var $return_success=$('.return-success',$element);

			function validateInput(input,type){
				var validationResult=validation(input,type);
				checkFormValidationState();
				return validationResult.valid;
			}

			function validation(input,type){
				var result=new Object();
				result.valid=true;
				result.mes="The field is valid";
				var value=$(input).val();
				switch(type){
					case"name":
					case"subject":
						if(value.length==''){
							result.valid=false;
							result.mes="Please enter a valid!";
						}
						saveValidationState(input,result.valid);
						showValidationMessage(input,result);
					break;
					case"message":
						if(value.length==''||value.length<=5){
							result.valid=false;
							result.mes="Please enter a valid!";
						}
					saveValidationState(input,result.valid);
					showValidationMessage(input,result);
					break;
					case"email":
						var re=/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
						if(!re.test(value)){result.valid=false;
							result.mes="Please enter a valid email!";
						}
						saveValidationState(input,result.valid);
						showValidationMessage(input,result);
					break;
					case'captchaCode':
						if(value.length==''||value.length<6){
							result.valid=false;
							result.mes="Please enter a valid!";
							saveValidationState(input,false);
							showValidationMessage(input,result);
						}else{
							saveValidationState(input,false);
							$(input).parent().removeClass('ctajax-error').removeClass('ctajax-ok');
							$('.el-captcha-loadding',$element).css('display','inline-block');
							$ca_submit.addClass('check-captcha');
							$.ajax({
								type:'POST',
								url:$ajax_url,
								data:{
									captcha:value,
									task:'checkcaptcha'
								},
								dataType:'json',
								success:function(data){
									$('.el-captcha-loadding',$element).css('display','none');
									$ca_submit.removeClass('check-captcha');
									saveValidationState(input,data.valid);
									showValidationMessage(input,data);
									checkFormValidationState();
								}
							});
						}
					break;
					default:break;
				}
				return result;
			}
			function saveValidationState(input,validationState){
				$(input).data("validated",validationState);
			}
			function checkFormValidationState(){
				var nameValid=$name.data("validated");
				var emailValid=$email.data("validated");
				var subjectValid=$subject.data("validated");
				var messageValid=$message.data("validated");
				var captchaValid=$captcha.data("validated");
				var check_valid='';
				check_valid=nameValid&&emailValid&&subjectValid&&messageValid;
				if(check_valid){
					return true;
				}else{
					return false;
				}
			}
			function showValidationMessage(input,validationResult){
				if(validationResult.valid===false){
					$(input).parent().addClass('ctajax-error').removeClass('ctajax-ok');
				}else{
					$(input).parent().removeClass('ctajax-error').addClass('ctajax-ok');
				}
			}

			var timer0=0;
			$name.on("keyup",function(e){
				if(timer0){
					clearTimeout(timer0);
					timer0=0;
				}
				timer0=setTimeout(function(){
					validateInput($name,"name");
				},1000);
			});

			var timer1=0;
			$email.on("keyup",function(e){
				if(timer1){
					clearTimeout(timer1);
					timer1=0;
				}
				timer1=setTimeout(function(){
					validateInput($email,"email");
				},1000);
			});
			var timer2=0;
			$subject.on("keyup",function(e){
				if(timer2){
					clearTimeout(timer2);
					timer2=0;
				}
				timer2=setTimeout(function(){
					validateInput($subject,"subject");
				},1000);
			});
			var timer3=0;
			$message.on("keyup",function(e){
				if(timer3){
					clearTimeout(timer3);
					timer3=0;
				}
				timer3=setTimeout(function(){
					validateInput($message,"message");
				},1000);
			});
			var timer4=0;
			$captcha.on("keyup",function(){
				if(timer4){
					clearTimeout(timer4);
					timer4=0;
				}
				timer4=setTimeout(function(){
					validateInput($captcha,"captchaCode");
				},1000);
			});
			$('.el-captcha-refesh',$element).on('click.refesh',function(){
				$captcha.val('');
			});

			$form.on('submit',function(){
				var $name_value=$.trim($name.val());
				var $email_value=$.trim($email.val());
				var $subject_value=$.trim($subject.val());
				var $message_value=$.trim($message.val());
				var $captcha_value=$.trim($captcha.val());
				var $newsletter_value=$newsletter.attr('checked')?1:0;
				var $check_empty='';
				$check_empty=$name_value==''||$subject_value==''||$email_value==''||$message_value=='';
				if(checkFormValidationState()==false||$check_empty){
					if($name_value==''){
						validateInput($name,"name");
					}
					if($email_value==''){
						validateInput($email,"email");
					}
					if($subject_value==''){
						validateInput($subject,"subject");
					}
					if($message_value==''||$message_value.length<=5){
						validateInput($message,"message");
					}
					return false;
				}else{
					if($ca_submit.hasClass('check-captcha')||$ca_submit.hasClass('ca-sending')){
						return false;
					}else{
						$ca_submit.addClass('ca-sending');
						$image_load.css('display','inline-block');
						$.ajax({
							type:'POST',
							url:$ajax_url,
							data:{
								"_token": $token.val(),
								nome:$name_value,
								email:$email_value,
								mensagem:$message_value,
								assunto:$subject_value,
								newsletter:$newsletter_value,
								task:'sendmail'
							},
							success:function(data){
								$image_load.css('display','none');
								if(typeof data.error!='undefined'&&data.error==0){
									$recaptcha.parent().removeClass('ctajax-ok').addClass('ctajax-error');
								}else{
									$recaptcha.parent().removeClass('ctajax-error').addClass('ctajax-ok');
									if(data.status==1){
										$return_success.css('display','inline-block');
									}else{
										$return_error.css('display','inline-block');
									}
								}
							},
							complete:function(data,xhr,status){
								$image_load.css('display','none');
								if(data.responseText=='{"error_captcha":0}'){
									$recaptcha.parent().removeClass('ctajax-ok').addClass('ctajax-error');
								}else{
									if(data.status==1)
									{
										$form.each(function(){
											this.reset();
										});

										$notice_return.delay(3000).fadeOut();
										$('.el-control').each(function(){
											$(this).removeClass('ctajax-ok');
										});
									}
								}
								$ca_submit.removeClass('ca-sending');
							},
							dataType:'json',
						});
					}
				}
				return false;
			});
		})('#contact_ajax1465581880428665692')
	});
</script>
<!-- Facebook Page Plugin -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Google Analytics -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-100289964-1', 'auto');
    ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
