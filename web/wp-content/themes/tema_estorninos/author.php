<?php get_header(); ?>

<div id="content" class="narrowcolumn">

<!-- This sets the $curauth variable -->

    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    ?>

    <!--<?php echo $curauth->nickname; ?>--> <?php echo $curauth->user_firstname; ?> <?php echo $curauth->user_lastname; ?>
    <dl>
        <dt>Sitio web:</dt>
        <dd><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></dd>
        <dt>Descripcion:</dt>
        <dd><?php echo $curauth->user_description; ?></dd>
    </dl>

    <h2>Posts by <?php echo $curauth->nickname; ?>:</h2>

    <ul>
<!-- The Loop -->

		  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <li>
            <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
            <?php the_title(); ?></a>,
            <?php the_time('d M Y'); ?> in <?php the_category('&');?>
        </li>

    <?php endwhile; else: ?>
        <p><?php _e('No posts by this author.'); ?></p>

    <?php endif; ?>
    
    
<?php get_footer(); ?>
