<?php
/*
Template Name: Advertise
*/
?>

<?php
if(isset($_POST['submitted'])) {
	if(trim($_POST['contactName']) === '') {
		$nameError = 'Please enter your name.';
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}

	if(trim($_POST['email']) === '')  {
		$emailError = 'Please enter your email address.';
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	if(trim($_POST['comments']) === '') {
		$commentError = 'Please enter a message.';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}

	if(!isset($hasError)) {
		$emailTo = get_option('tz_email');
		if (!isset($emailTo) || ($emailTo == '') ){
			$emailTo = get_option('admin_email');
		}
		$subject = 'Sponsorship Inquiry From '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}

} ?>

<?php get_header(); ?>

<div class="grid_max">

	<div class="four right adspot">
			 <div class="ad">
			   <img src="http://placehold.it/150x100" width="150" height="100" />
			   <h3><a href="#">Product Name</a></h3>
			   <p>This is where we give you an up to 60 character product or service description.</p>
			 </div><!-- .ad -->
			</div><!-- .four -->
		  
		<div class="seven">
		  
		    <h2>Want to sponsor the show? Sweet!</h2>
		  
		    <p>We're honored that you'd want to sponsor the show! Thanks! We're looking for sponsors whose products or services will really benefit our listeners. For that reason, we really make an effort to hand pick who advertises on our site. We only accept sponsors who's products we use, have used or will use.</p>
		    <p>If you don't have a product to advertise, but are interested in supporting the show, consider <a href="/membership">becoming a member</a>. We appreciate your support!</p>
		    
		    <p>Fill out the form below with your name, email and a brief decription of what you want to advertise and we'll get back to you as soon as possible!</p>
		    
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
						<?php if(isset($emailSent) && $emailSent == true) { ?>
								<h2>Thanks, your email was sent successfully.</h2>
						<?php } else { ?>
							<?php the_content(); ?>
							<?php if(isset($hasError) || isset($captchaError)) { ?>
								<p class="error">Sorry, an error occured.<p>
							<?php } ?>

						<form action="<?php the_permalink(); ?>" class="contactForm" method="post">
						  
							<fieldset>
								<input type="text" name="contactName" placeholder="Name" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="input required requiredField" />
								<?php if($nameError != '') { ?>
									<span class="error"><?=$nameError;?></span>
								<?php } ?>
								
								<input type="email" name="email" placeholder="Email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="input required requiredField email" />
								<?php if($emailError != '') { ?>
									<span class="error"><?=$emailError;?></span>
								<?php } ?>
							
								<textarea name="comments" placeholder="Tell us about your product. Remember to give us a link!" class="input message required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
								<?php if($commentError != '') { ?>
									<span class="error"><?=$commentError;?></span>
								<?php } ?>
								
								<input class="send button" type="submit" value="Send Email"></input>
								</fieldset>

								
							</li>
						</ul>
						<input type="hidden" name="submitted" id="submitted" value="true" />
					</form>
				<?php } ?>
			</div><!-- .post -->

				<?php endwhile; endif; ?>
		</div><!-- .seven -->
			
	</div><!-- .grid_max -->

<?php get_footer(); ?>