<?php

    global $cached;
    $incumbent = retrieve_incumbent_info($fourcode);
    $img_src = $incumbent['IMG']?$incumbent['IMG']:url('assets/imgs/avatar.png');
    $cand_id = $incumbent['CAND_ID']??null;

    $social = retrieve_incumbent_social_media($cand_id);
    $fb = $social['facebook'] ?? '';
    $tw = $social['twitter'] ?? '';



?>

<div class="row ctb-incumbentBox">
    <div class="col-md-12 px-0">

        <div class="ctb-incumbent-img">
            <div class="ctb-incumbent-banner-img">
                <img src="<?php echo url('assets/imgs/flag-bg.png') ?>" alt="banner" class="img-fluid" />
            </div>
        </div>
    </div>
    <div class="col-md-12 ctb-incumbentBox-content">
        <div class="d-flex align-items-end justify-content-between px-5 ctb-incumbentBox-avatar">
            <div class="ctb-incumbent-profile-img text-center"> 
                <img src="<?= $img_src ?>" alt="profile" class="img-fluid"  />
            </div>
            <div>
                <?php if ($fb){ ?>
                    <a href="https://www.facebook.com/<?= $fb ?>" target="_blank" class="ctb-facebook-btn text-decoration-none" >
                        <img src="<?php echo  url('assets/imgs/facebook.png') ?>" alt="fb" />Follow
                    </a>
                <?php }if ($tw) {?>
                    <a href="https://twitter.com/<?= $tw ?>" target="_blank" class="ctb-twitter-btn text-decoration-none">
                        <img src="<?php echo url('assets/imgs/twitter.png')?>" alt="twitter" />Follow
                    </a>
                <?php }?>
            </div>
        </div>
        <div>
            <h2><?= $incumbent['INCUMBENT']??'' ?> (<?= $incumbent['PARTY']??'' ?>)</h2>
            <span>Born: <?= $incumbent['DOB'] ?? '' ?> | Term <?=  $incumbent['TERM_LIMIT'] ?? ''  ?></span>
            <p><?=  $incumbent['BIO'] ?? ''  ?></p>
        </div>
    </div>
</div>


