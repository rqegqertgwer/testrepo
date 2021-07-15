<?php
/**
 * Template Name: Custome template
 *
 * A custom page New Shop page
 *
 * The "Template Name:" New Shop page
 * 
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
 get_header(); ?>
<section class="CollectiveTeacherEfficacy MeasuringEnabling">
  <div class="container">
   <div class="custom-footer-div">	
	<?php if( have_rows('category_sec') ): ?>
	    <?php while( have_rows('category_sec') ): the_row();
	        // Get sub field values.
	        $image = get_sub_field('first_sec_image');
	       
	        ?>
	        <div id="hero">
	        	
	        	<div class="row main3head ">
        		<div class="col-md-6 col-sm-12">
		            <div class="section-info">
		            	<h4><?php the_sub_field('category_name'); ?></h4>
		                
		            </div>
           	 	</div>
	        	<div class="col-md-6 col-sm-12 imgmain">	
	                    <h2><?php the_sub_field('sub-category'); ?></h2>
						<p><?php the_sub_field('sub-category'); ?></p>
	       		</div>
	           
	        </div>
	        </div>
	    <?php endwhile; ?>
	<?php endif; ?>
	</div>
  </div>
</section>
<section class="CollectiveTeacherEfficacy ImportantCollective">
  <div class="container">
   <div class="custom-footer-div">	
	<?php if( have_rows('shipping_per_country') ): ?>
	    <?php while( have_rows('shipping_per_country') ): the_row();
	        // Get sub field values.
	        //$image = get_sub_field('first_sec_image');
	        ?>
	        <div id="hero">
	        	
	        	<div class="row main3head ">
	        	<div class="col-md-6 col-sm-12 imgmain">
                       <h4><?php the_sub_field('shpping_heading'); ?></h4>				
	       		</div>
	            <div class="col-md-6 col-sm-12">
		            <div class="section-info">
		            	
		                <?php the_sub_field('accordion_sec');?>
		            </div>
	            </div>
	        </div>
	        </div>
	    <?php endwhile; ?>
	<?php endif; ?>
	</div>
  </div>
</section>
<?php get_footer(); ?>