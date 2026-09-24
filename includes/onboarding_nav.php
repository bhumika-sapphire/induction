<ul class="steps-list">
    <?php foreach (onboarding_steps() as $i => $step) { ?>
        <li <?php if ($step['page_id'] == $active_page_id) echo 'class="active"'; ?>>
            <a href="<?php echo onboarding_step_url($step['page_id']); ?>"><span class="num"><?php echo $i + 1; ?>.</span> <?php echo h($step['nav_title']); ?></a>
        </li>
    <?php } ?>
    <li <?php if ($active_page_id == 'end') echo 'class="active"'; ?>>
        <a href="ending.php"><span class="num"><i class="fa fa-flag-checkered"></i></span> Finish</a>
    </li>
</ul>
