<?php
$header = get_sub_field('header');
$header_tag = get_sub_field('header_tag');
$nr_blogposts = get_sub_field('nr_blogposts');
$link = get_sub_field('link');

$args = array(
	'post_type'              => array( 'post' ),
	'posts_per_page'         => $nr_blogposts,
);

parse_str($_SERVER["QUERY_STRING"], $query_array);
$active_cat = '';
if (array_key_exists(__('kategori'),$query_array)) :
    $active_cat = $query_array[__('kategori')];
endif;

$latest_blog_posts = new WP_Query( $args );
?>
<?php if(!$active_cat) : ?>
    <section class="component component-latest_blogposts">
        <div class="container-fluid">
            <?php if($header) : ?>
                <<?php echo $header_tag; ?> class="h1">
                    <?php echo $header; ?>
                </<?php echo $header_tag; ?>>
            <?php endif; ?>

            <?php
            if ( $latest_blog_posts->have_posts() ) :
                $i = 0;
                while ( $latest_blog_posts->have_posts() ) :
                    $latest_blog_posts->the_post();

                    if($i == 0) :
                        get_template_part('templates/content', 'blog_featured');
                    else:
                        get_template_part('templates/content', 'blog_excerpt');
                    endif;

                    $i++;
                endwhile;
            endif;
            wp_reset_postdata();
            ?>

            <?php if($link) : ?>
                <p class="link">
                    <a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>">
                        <?php echo $link['title']; ?>
                    </a>
                </p>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>