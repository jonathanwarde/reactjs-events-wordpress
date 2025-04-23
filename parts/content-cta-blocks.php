<?php
$cta_blocks = get_field('cta_blocks', 'option');

if ($cta_blocks): ?>
    <ul class="cta-blocks cta-blocks--grid-3 width-lg">
        <?php foreach ($cta_blocks as $cta_block): ?>
            <li class="cta-blocks__block">
                <div class="cta-blocks_block-text">
                    <h2><?php echo esc_html($cta_block['cta_title']); ?></h2>
                    <p><?php echo esc_html($cta_block['cta_description']); ?></p>
                </div>
                <a href="<?php echo esc_url(get_permalink($cta_block['cta_link'])); ?>" class="cover-link"></a>
                <img src="<?php echo esc_url($cta_block['cta_image']); ?>" class="cta-blocks__img" loading="lazy" />
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
