<?php
/**
 * Template Name: Custome12 template
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
        		<div class="col-md-4 col-sm-12">
		            <div class="section-info">
		            	<h4><?php the_sub_field('category_name'); ?></h4>
		                <h5>Products Tags</h5>

		          <?php
		    
						
		           $terms = get_terms(array('taxonomy' => 'product_tag', 'hide_empty' => false)); ?>
				  <div class="product-tags">
				<?php foreach ( $terms as $term ) { ?>
				    <a href="<?php echo get_term_link( $term->term_id, 'product_tag' ); ?> " rel="tag"><?php echo $term->name; ?></a>
					 <?php } ?>



        
</div>
		            </div>
           	 	</div>
	        	<div class="col-md-6 col-sm-12 imgmain">	
	                    <h3><?php the_sub_field('product'); ?></h3>

<?php if( ! empty( get_field( 'product' ) ) )
    echo do_shortcode( '[products limit="4" columns="4" class="brand,' . get_field( 'product' ) . '"]'); ?>
	       		</div>
	           
	        </div>
	        </div>
	        <hr>
	    <?php endwhile; ?>
	<?php endif; ?>
	</div>
  </div>
</section>

<?php get_footer(); ?>